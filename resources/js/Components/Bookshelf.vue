<template>
    <div class="bookshelf my-3">
        <div v-if="books.length > 0">
            <div class="shelf" v-for="(shelf, index) in shelves" :key="index">
                <div class="book" v-for="book in shelf" :key="book.id">
                    <img :src="book.cover_image" :alt="book.title" class="cover-image"
                         @click="$emit('book-click', book)">
                    <div class="book-details">
                        <div class="buttons flex">
                            <a :href="route('books.show', book.id)" class="details-link">Details</a>
                            <button @click="$emit('add-to-list', book)" class="details-link">Add to bookshelf</button>
                        </div>
                        <h2 class="title">{{ book.title }}</h2>
                        <p class="author">{{ book.author }}</p>
                    </div>
                </div>
            </div>
        </div>
        <main v-else class="py-10">
            <div class="py-12">
                <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div class="bg-white rounded-lg shadow-md p-6"><p class="text-gray-700 leading-relaxed">Your bookshelf is empty. Add some books to start your collection!</p></div>
                </div>
            </div>
        </main>
    </div>
</template>

<script>
export default {
    props: {
        books: {
            type: Array,
            required: true,
        },
    },
    computed: {
        shelves() {
            const shelves = [];
            let currentShelf = [];
            let shelfSize = 0;

            for (const book of this.books) {
                if (shelfSize >= 5) { // Adjust the number to control the number of books per shelf
                    shelves.push(currentShelf);
                    currentShelf = [];
                    shelfSize = 0;
                }

                currentShelf.push(book);
                shelfSize++;
            }

            if (currentShelf.length > 0) {
                shelves.push(currentShelf);
            }

            return shelves;
        },
    },
};
</script>

<style scoped>
/* resources/js/Components/Bookshelf.vue */

.bookshelf {
    display: flex;
    flex-direction: column;
    width: 100%;
}

.shelf {
    display: flex;
    margin-bottom: 1rem;
    justify-content: space-evenly;
}

.book {
    width: 150px; /* Adjust the width as needed */
    margin-right: 1rem;
    perspective: 1000px; /* Add perspective for the 3D tilt effect */
}

.book:hover .cover-image {
    transform: rotateY(-10deg); /* Tilt the book slightly on hover */
}

.cover-image {
    width: 100%;
    height: 200px; /* Adjust the height as needed */
    background-color: #f0f0f0; /* Set a default background color */
    border: 1px solid #ddd; /* Add a subtle border */
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease; /* Add a smooth transition for the hover effect */
}

.cover-image::before {
    content: '';
    display: block;
    padding-top: 150%; /* Maintain a 3:4 aspect ratio for the cover image */
}

.book .author {
    font-family: 'Your Font', sans-serif; /* Replace with your font */
    font-size: 0.75rem;
    color: #666; /* Adjust the color as needed */
}

.book-details {
    margin-top: 0.5rem;
    text-align: center; /* Center the links and text */
}

.book .buttons a:first-child:not(:only-child) {
    border-right: 1px solid rgba(100, 105, 106, 0.3);
}

.details-link {
    display: inline-block;
    padding: 0 8px;
    color: rgba(100, 105, 106, 0.7);
    text-transform: uppercase;
    letter-spacing: 1px;
    font-size: 0.65em;
    line-height: 1.5;
    text-wrap-mode: nowrap;
}
</style>
