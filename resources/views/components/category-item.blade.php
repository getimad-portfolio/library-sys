<div class="flex place-items-center p-2 rounded-md even:bg-gray-50 odd:bg-white shadow-2xl shadow-gray-100 border">
    <span class="w-1/12">
        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 8.25h15m-16.5 7.5h15m-1.8-13.5-3.9 19.5m-2.1-19.5-3.9 19.5" />
        </svg>
    </span>
    <span class="w-32 px-2 font-semibold">{{ $category->name }}</span>
    <span class="flex-grow px-2">{{  Str::limit($category->description, 110, '...') }}</span>
    <div class="flex gap-2 items-center justify-center">
        <form action="{{ route('categories.update', $category->id) }}" method="POST" class="grid place-items-center">
            @csrf
            @method('PUT')
            <input type="color" id="favcolor" name="favcolor" value="{{ $category->color }}" onchange="this.form.submit()">
        </form>
    </div>
</div>