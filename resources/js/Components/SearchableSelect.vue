<template>
    <div>
        <input type="text" v-model="searchQuery" placeholder="Search..." class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        <ul v-if="filteredOptions.length > 0" class="mt-2">
            <li v-for="option in filteredOptions" :key="option.id" @click="selectOption(option)" class="cursor-pointer py-1 px-2 hover:bg-gray-100">
                {{ option[label] }}
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    props: {
        options: {
            type: Array,
            required: true,
        },
        label: {
            type: String,
            default: 'name',
        },
        placeholder: {
            type: String,
            default: 'Select an option',
        },
    },
    data() {
        return {
            searchQuery: '',
        };
    },
    computed: {
        filteredOptions() {
            return this.options.filter(option => option[this.label].toLowerCase().includes(this.searchQuery.toLowerCase()));
        },
    },
    methods: {
        selectOption(option) {
            this.$emit('input', option);
            this.searchQuery = '';
        },
    },
};
</script>
