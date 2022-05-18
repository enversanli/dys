<template>
    <div class="w-full shadow-lg my-10 p-5">
        <div class="flex w-full">
            <div class="w-full">
                <label for="first_name">Adı</label>
                <input id="first_name" type="text"
                       class="w-full my-5 border-gray-800 mr-5 border p-2 border-slate-400 rounded" name="first_name">
            </div>
            <div class="w-full">
                <label for="last_name">Soyadı</label>
            <input id="last_name" type="text" class="w-full my-5 ml-5 border p-2 border-slate-400 rounded" name="last_name">
            </div>
        </div>

        <div class="flex w-full">
            <div class="w-full">
                <label for="first_name">Adı</label>
                <input id="birth_date" type="date"
                       class="w-full my-5 border-gray-800 mr-5 border p-2 border-slate-400 rounded" name="first_name">
            </div>
            <div class="w-full">
                <label for="last_name">Soyadı</label>
                <input id="last_name" type="text" class="w-full my-5 ml-5 border p-2 border-slate-400 rounded" name="last_name">
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "StoreStudentComponent"
}
</script>

<style scoped>

</style>
