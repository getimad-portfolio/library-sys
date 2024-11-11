<div class="flex place-items-center p-2 rounded-md even:bg-gray-50 odd:bg-white">
    <span class="w-1/12">
        <svg class="w-8 h-8 text-gray-800" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
        </svg>
    </span>
    <span class="w-1/6 px-2">{{ $cnie }}</span>
    <span class="w-1/4 font-semibold px-2">{{ $fullName }}</span>
    <span class="w-1/3 px-2">{{ $email }}</span>
    <span class="w-1/5 px-2">{{ $phoneNumber }}</span>
    <div class="flex gap-2 items-center justify-center">
        <a href="{{ route('members.edit', $memberId) }}" class="font-bold bg-green-500 p-2 rounded-full">         
        </a>
        <form action="{{ route('members.destroy', $memberId) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this book?');" class="grid place-items-center">
            @csrf
            @method('DELETE')
            <button type="submit" class="font-bold bg-red-500 p-2 rounded-full">                 
            </button>
        </form>
    </div>
</div>