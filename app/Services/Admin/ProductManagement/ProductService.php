<?php

namespace App\Services\Admin\ProductManagement;

use App\Http\Traits\FileManagementTrait;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductInformation;
use App\Models\ProductRelation;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class ProductService
{
    use FileManagementTrait;
    public function getProducts($orderby = 'sort_order', $order = 'asc')
    {
        return Product::orderBy($orderby, $order)->latest();
    }

    public function getProduct(string $encryptedId): Product|Collection
    {
        return Product::findOrFail(decrypt($encryptedId));
    }
    public function getDeletedProduct(string $encryptedId): Product|Collection
    {
        return Product::onlyTrashed()->findOrFail(decrypt($encryptedId));
    }


    public function basicInfoCreate(array $data): Product
    {
        $data['created_by'] = admin()->id;
        $data['status'] = Product::STATUS_DEACTIVE;
        $data['entry_status'] = Product::ENTRY_STATUS_RELATION;
        $data['meta_keywords'] = json_encode($data['meta_keywords']);
        return Product::create($data);
    }

    public function relationCreate(Product $product, array $data, $type = 'create'): ProductRelation
    {
        return DB::transaction(function () use ($data, $product, $type) {
            $product->update(['entry_status' => Product::ENTRY_STATUS_IMAGE]);
            $type == 'create' ? $data['created_by'] = admin()->id : $data['updated_by'] = admin()->id;
            return ProductRelation::updateOrCreate(['product_id' => $product->id], $data);
        });
    }

    public function imageCreate(Product $product, array $data)
    {
        return DB::transaction(function () use ($data, $product) {

            $data['created_by'] = admin()->id;
            $data['product_id'] = $product->id;
            if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
                $images = ProductImage::where('product_id', $product->id)->get();
                foreach ($images as $image) {
                    $this->fileDelete($image->image);
                    $image->forceDelete();
                }
                $file = $data['image'];
                $data['image'] = $this->handleFileUpload($file, 'products');
                ProductImage::create(array_merge($data, ['is_primary' => ProductImage::IS_PRIMARY]));
            }
            if (isset($data['images'])) {
                foreach ($data['images'] as $image) {
                    if ($image instanceof UploadedFile) {
                        $file = $image;
                        $data['image'] = $this->handleFileUpload($file, 'products');
                        ProductImage::create($data);
                    }
                }
            }
            $product->update(['entry_status' => Product::ENTRY_STATUS_INFORMATION]);

        });
    }

    public function infoCreate(Product $product, array $data, $type = 'create')
    {
        ($type == 'create' ? $data['created_by'] = admin()->id : $data['updated_by'] = admin()->id);
        return ProductInformation::updateOrCreate(['product_id' => $product->id, 'product_info_cat_id' => $data['product_info_cat_id'], 'product_info_cat_type_id' => $data['product_info_cat_type_id']], ['product_info_cat_type_feature_id' => $data['product_info_cat_type_feature_id'], 'description' => $data['description']]);

    }

    public function infoRemarkCreate(Product $product, array $data, $type = 'create')
    {
        ($type == 'create' ? $data['created_by'] = admin()->id : $data['updated_by'] = admin()->id);
        $record = ProductInformation::where('product_id', $product->id)
            ->where('product_info_cat_id', $data['product_info_cat'])
            ->whereNotNull('remarks')
            ->first();

        if ($record) {
            $record->update(['remarks' => $data['remarks']]);
        } else {
            $record = ProductInformation::create([
                'product_id' => $product->id,
                'product_info_cat_id' => $data['product_info_cat'],
                'remarks' => $data['remarks'],
            ]);
        }

    }
    public function getProductEntryComplete($encryptedId)
    {
        $product = $this->getProduct($encryptedId);
        if ($product->entry_status == Product::ENTRY_STATUS_INFORMATION) {
            $product->update(['entry_status' => Product::ENTRY_STATUS_COMPLETE,'status'=> Product::STATUS_ACTIVE]);
            return true;
        }else{
            return false;
        }

    }
    public function getInfos(string $encryptedId): ProductInformation|Collection
    {
        return ProductInformation::with(['infoCategory','infoCategoryType','infoCategoryTypeFeature'])->where('product_id', decrypt($encryptedId))->whereNull('remarks')->select('id','product_info_cat_id', 'product_info_cat_type_id', 'product_info_cat_type_feature_id', 'description')->latest()->get();
    }
    public function getInfoRemarks(string $encryptedId): ProductInformation|Collection
    {
        return ProductInformation::with('infoCategory')->where('product_id', decrypt($encryptedId))->whereNotNull('remarks')->select('id','product_info_cat_id', 'remarks')->latest()->get();
    }
     public function getProductInfo(string $encryptedId): ProductInformation|Collection
    {
        return ProductInformation::findOrFail(decrypt($encryptedId));
    }

    public function update(string $encryptedId, array $data): Product
    {
        $product = $this->getProduct($encryptedId);
        $data['updated_by'] = admin()->id;
        $product->update($data);
        return $product;
    }
    public function delete(string $encryptedId): void
    {
        $product = $this->getProduct($encryptedId);
        $product->update(['deleted_by' => admin()->id]);
        $product->delete();
    }

    public function restore(Product $product): void
    {
        $product->update(['deleted_by' => null]);
        $product->restore();
    }

    public function permanentDelete(Product $product): void
    {
        $product->forceDelete();
    }
}
