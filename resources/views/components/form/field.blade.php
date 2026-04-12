 @props(['label','name', 'type'=>'text'])

 <div class="form-control w-full space-y-2">
     <label for="{{ $name }}" class="label">{{ $label }}</label>
     <input type="{{ $type }}" value="{{ old($name) }}" class="input w-full" id="{{ $name }}" name="{{ $name }}" placeholder="{{ $label }}" {{ $attributes }}>

     @error($name)
         <p class="error">{{ $message }}</p>
    @enderror
 </div>
