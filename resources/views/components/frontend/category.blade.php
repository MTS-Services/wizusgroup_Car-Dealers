<div
    class="relative group overflow-hidden rounded-md shadow-shadowPrimary w-full h-64 lg:h-72 bg-bg-white dark:bg-bg-black dark:bg-opacity-60">

    <img src="{{ asset($category->modified_image) }}" alt="{{ $category->name }}"
        class="absolute top-0 left-0 w-full h-full object-cover" />

    <h2
        class="absolute bottom-0 left-0 w-full px-3 py-5 bg-bg-gray dark:bg-bg-dark bg-opacity-70 dark:bg-opacity-70 text-center text-text-primary dark:text-text-white rounded-t-md translate-y-full opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-300 ease-linear text-base !capitalize">
        {{ $category->name }}
    </h2>
</div>
