   @props(['product'])
   <dialog id="inquiry-{{ $product->slug }}" class="modal">
       <div class="modal-box max-w-screen-xl">
           <form method="dialog" class="flex justify-between items-center mb-3">
               <h3 class="text-xl font-semibold">
                   {{ __('Product Inquiry') }}</h3>
               <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2"><i data-lucide="x"
                       class="w-5 h-5"></i></button>
           </form>
           </form>
           <form action="{{ route('user.p.inquiry-store', $product->slug) }}" method="POST">
               @csrf
               <input type="hidden" name="form_type" value="inquiry">
               <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                   <div class="col-span-2">
                       <label for="in_name" class="label">{{ __('Contact Name') }} <span
                               class="text-red-500">*</span></label>
                       <input type="text" class="input" value="{{ old('in_name') }}" name="in_name"
                           placeholder="Enter name" id="in_name">
                       <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'in_name']" />
                   </div>
                   <div>
                       <label for=in_"email" class="label">{{ __('Contact Email') }} <span
                               class="text-red-500">*</span></label>
                       <input type="text" class="input" value="{{ old('in_email') }}" name="in_email"
                           placeholder="Enter email" id="in_email">
                       <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'in_email']" />
                   </div>
                   <div>
                       <label for="in_whatsapp_number" class="label">{{ __('Contact Whatsapp Number') }} <span
                               class="text-red-500">*</span></label>
                       <input type="text" class="input" value="{{ old('in_whatsapp_number') }}" name="in_whatsapp_number"
                           placeholder="Enter whatsapp number" id="in_whatsapp_number">
                       <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'in_whatsapp_number']" />
                   </div>
               </div>
               <button type="submit" class="btn-primary mt-5">{{ __('Reserve & Inquiry') }}</button>
           </form>
       </div>
   </dialog>
