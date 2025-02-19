<div>
    
    {{-- Tipo de Producto --}}
    <div>
        <label for="product_type_id" class="block text-sm font-medium text-gray-700">Tipo de Producto</label>
        <select wire:model.lazy="selectedProductType" id="product_type_id" class="mt-1 p-2 w-full border rounded">
            <option value="">Seleccione un tipo</option>
            @foreach ($productTypes as $type)
                <option value="{{ $type->id }}">{{ $type->name }}</option>
            @endforeach
        </select>
    </div>

    {{-- Categoría --}}
    <div class="mt-4">
        <label for="category_id" class="block text-sm font-medium text-gray-700">Categoría</label>
        <select wire:model.lazy="selectedCategory" id="category_id" class="mt-1 p-2 w-full border rounded"
            @if (empty($categories)) disabled @endif>
            <option value="">Seleccione una categoría</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
    </div>

    {{-- Subcategoría --}}
    <div class="mt-4">
        <label for="subcategory_id" class="block text-sm font-medium text-gray-700">Subcategoría</label>
        <select wire:model.lazy="selectedSubcategory" id="subcategory_id" class="mt-1 p-2 w-full border rounded"
            @if (empty($subcategories)) disabled @endif>
            <option value="">Seleccione una subcategoría</option>
            @foreach ($subcategories as $subcategory)
                <option value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>
            @endforeach
        </select>
    </div>
</div>
