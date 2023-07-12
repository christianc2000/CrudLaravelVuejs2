<template>
  <div id="app">
    <form @submit.prevent="addItem">
      <input type="text" v-model="newItemName" />
      <button type="submit">Agregar</button>
    </form>
    <table id="dataTable">
      <thead>
        <tr>
          <th>id</th>
          <th>Nombre</th>
          <th>Opciones</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in items" :key="item.id">
          <td>{{ item.id }}</td>
          <td>{{ item.name }}</td>
          <td>
            <!-- Agrega los enlaces para editar y eliminar el item -->
            <button @click="editItem(item)">Editar</button>
            <button @click="deleteItem(item)">Eliminar</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import axios from "axios";
import $ from "jquery";
import "datatables.net";

export default {
  data() {
    return {
      items: [],
      newItemName: "",
    };
  },
  mounted() {
    this.fetchItems();
  },
  methods: {
    fetchItems() {
      axios
        .get('/api/users')
        .then((response) => {
          this.items = response.data;
          this.$nextTick(() => {
            $(this.$el).find("#dataTable").DataTable();
          });
        })
        .catch((error) => {
          console.error(error);
        });
    },
    addItem() {
      axios
        .post("/api/users", { name: this.newItemName })
        .then((response) => {
          this.fetchItems();
          this.newItemName = "";
        })
        .catch((error) => {
          console.error(error);
        });
    },
    editItem(item) {
      // Implementa la lógica para editar un item
    },
    deleteItem(item) {
      axios
        .delete(`/api/users/${item.id}`)
        .then((response) => {
          this.fetchItems();
        })
        .catch((error) => {
          console.error(error);
        });
    },
  },
};
</script>
