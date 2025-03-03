<template>
    <div class="flex items-center">
    <span v-for="n in 5" :key="n" class="text-lg">
      <i class="fa-star"
         :class="[
           (n <= Math.floor(rating)) ? 'fas text-yellow-400' :
           (n - 0.5 <= rating) ? 'fas fa-star-half-alt text-yellow-400' :
           'far text-yellow-400'
         ]"></i>
    </span>
    </div>
</template>

<script>
export default {
    props: {
        rating: {
            type: Number,
            required: true,
        },
    },
};
</script>
