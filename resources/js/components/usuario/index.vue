<!-- resources/js/components/ItemComponent.vue -->
<template>
    <div>
        <form @submit.prevent="addItem">
            <input type="text" v-model="newItemName">
            <button type="submit">Agregar</button>
        </form>

    
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            items: [],
            newItemName: '',
        };
    },
    mounted() {
        this.fetchItems();
    },
    methods: {
        fetchItems() {
            axios.get('/api/users')
                .then(response => {
                    this.items = response.data;
                })
                .catch(error => {
                    console.error(error);
                });
        },
        addItem() {
            axios.post('/api/userss', { name: this.newItemName })
                .then(response => {
                    this.fetchItems();
                    this.newItemName = '';
                })
                .catch(error => {
                    console.error(error);
                });
        },
        editItem(item) {
            // Implementa la lógica para editar un item
        },
        deleteItem(item) {
            axios.delete(`/api/users/${item.id}`)
                .then(response => {
                    this.fetchItems();
                })
                .catch(error => {
                    console.error(error);
                });
        },
    },
};
</script>
