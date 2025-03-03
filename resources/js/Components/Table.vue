<template>
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
        <tr>
            <th
                v-for="(column, index) in columns"
                :key="index"
                scope="col"
                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                @click="$emit('sort', column)"
            >
                {{ column.header || column }}
            </th>
            <th scope="col" class="relative px-6 py-3">
                <span class="sr-only">Edit</span>
            </th>
        </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
        <tr v-for="(item, rowIndex) in items" :key="rowIndex">
            <td v-for="(column, columnIndex) in columns" :key="columnIndex" class="px-6 py-4 whitespace-nowrap">
                <!--div v-if="column === 'my_rating'">
                    <StarRating :rating="item[column]" />
                </div-->
                <div class="text-sm text-gray-900">{{ item[column] }}</div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                <template v-for="(action, actionIndex) in actions" :key="actionIndex">
                    <Link v-if="action.route" :href="route(action.route, item.id)" class="text-orange-500 hover:text-orange-700 mr-2">
                        <i :class="action.icon" ></i>
                    </Link>
                    <button v-else @click="emit('action', action.name, item)" class="text-orange-500 hover:text-orange-700 mr-2">
                        <i :class="action.icon" ></i>
                    </button>
                </template>
            </td>
        </tr>
        </tbody>
    </table>
</template>

<script>
import StarRating from '@/Components/StarRating.vue';
import {Link} from "@inertiajs/vue3";

export default {
    components: {
        StarRating,
        Link
    },
    props: {
        columns: {
            type: Array,
            required: true,
        },
        items: {
            type: Array,
            required: true,
        },
        actions: {
            type: Array,
            required: true,
        }
    },
    emits: ['action'],
}
</script>
