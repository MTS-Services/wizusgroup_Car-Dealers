   @props(['product'])
   <dialog id="reserve-{{ $product->slug }}" class="modal">
       <div class="modal-box max-w-screen-xl">
           <form method="dialog" class="flex justify-between items-center mb-3">
               <h3 class="text-xl font-semibold">
                   {{ __('Product Reserve') }}</h3>
               <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2"><i data-lucide="x"
                       class="w-5 h-5"></i></button>
           </form>
           </form>
           <form action="{{ route('user.p.reserve-store', $product->slug) }}" method="POST">
               @csrf
               <input type="hidden" name="form_type" value="reserve">
               <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                   <div>
                       <label for="name" class="label">{{ __('Contact Name') }} <span
                               class="text-red-500">*</span></label>
                       <input type="text" class="input" value="{{ old('name') }}" name="name"
                           placeholder="Enter name" id="name">
                       <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'name']" />
                   </div>
                   <div>
                       <label for="email" class="label">{{ __('Contact Email') }} <span
                               class="text-red-500">*</span></label>
                       <input type="text" class="input" value="{{ old('email') }}" name="email"
                           placeholder="Enter email" id="email">
                       <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'email']" />
                   </div>
                   <div>
                       <label for="whatsapp_number" class="label">{{ __('Contact Whatsapp Number') }} <span
                               class="text-red-500">*</span></label>
                       <input type="text" class="input" value="{{ old('whatsapp_number') }}" name="whatsapp_number"
                           placeholder="Enter whatsapp number" id="whatsapp_number">
                       <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'whatsapp_number']" />
                   </div>
                   <div>
                       <label for="reserve_price" class="label">{{ __('Reserve Price') }} <span
                               class="text-red-500 text-xs">{{ __('Min Half of Product Price') }}</span></label>
                       <input type="text" class="input"
                           value="{{ old('reserve_price', round($product->price / 2)) }}" name="reserve_price"
                           placeholder="Enter reserve price" id="reserve_price">
                       <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'reserve_price']" />
                   </div>
                   <div class="col-span-2">
                       <label for="note" class="label">{{ __('Notes') }}</label>
                       <textarea class="textarea" placeholder="Bio" name="note" id="note">{{ old('note') }}</textarea>
                       <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'note']" />
                   </div>
               </div>
               <button type="submit" class="btn-primary mt-5">{{ __('Reserve & Inquiry') }}</button>
           </form>
       </div>
   </dialog>
