<div>
    {{-- Tipo de Producto --}}
    <div>
        <label for="product_type_id" class="block text-sm font-medium text-gray-700">Tipo de Producto</label>
        <select wire:model.lazy="selectedProductType" name="product_type_id" id="product_type_id" class="mt-1 p-2 w-full border rounded">
            <option value="">Seleccione un tipo</option>
            @foreach ($productTypes as $type)
                <option value="{{ $type->id }}" {{ old('product_type_id', $selectedProductType) == $type->id ? 'selected' : '' }}>
                    {{ $type->name }}
                </option>
            @endforeach
        </select>

        {{-- 🔥 Campo hidden para asegurarnos de que se envía correctamente --}}
        <input type="hidden" name="product_type_id" value="{{ old('product_type_id', $selectedProductType) }}">
    </div>

    {{-- Categoría --}}
    <div class="mt-4">
        <label for="category_id" class="block text-sm font-medium text-gray-700">Categoría</label>
        <select wire:model.lazy="selectedCategory" name="category_id" id="category_id" class="mt-1 p-2 w-full border rounded"
            @if (empty($categories)) disabled @endif>
            <option value="">Seleccione una categoría</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" {{ old('category_id', $selectedCategory) == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>

        {{-- Campo hidden para asegurarnos de que se envía correctamente --}}
        <input type="hidden" name="category_id" value="{{ old('category_id', $selectedCategory) }}">
    </div>

    {{-- Subcategoría --}}
    <div class="mt-4">
        <label for="subcategory_id" class="block text-sm font-medium text-gray-700">Subcategoría</label>
        <select wire:model.lazy="selectedSubcategory" name="subcategory_id" id="subcategory_id" class="mt-1 p-2 w-full border rounded"
            @if (empty($subcategories)) disabled @endif>
            <option value="">Seleccione una subcategoría</option>
            @foreach ($subcategories as $subcategory)
                <option value="{{ $subcategory->id }}" {{ old('subcategory_id', $selectedSubcategory) == $subcategory->id ? 'selected' : '' }}>
                    {{ $subcategory->name }}
                </option>
            @endforeach
        </select>

        {{-- Campo hidden para asegurarnos de que se envía correctamente --}}
        <input type="hidden" name="subcategory_id" value="{{ old('subcategory_id', $selectedSubcategory) }}">
    </div>
</div>
