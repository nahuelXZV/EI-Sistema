@props(['value', 'title', 'col' => '1'])
<div class="relative z-0 mb-1 w-full group col-span-{{ $col }}">
    <label name="floating_password" id="floating_password"
        class="block py-1.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600  focus:outline-none focus:ring-0  peer">{{ $value }}</label>
    <label for="floating_password"
        class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{ $title }}</label>
</div>
