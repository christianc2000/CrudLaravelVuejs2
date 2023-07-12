<template>
  <div id="app" class="form-control">
    <form @submit.prevent="addItem" class="mb-4">
      <div class="card" style="width: 100%">
        <div class="card-body">
          <label>Nombre</label>
          <input type="text" v-model="newItemName" />
          <label>Correo</label>
          <input type="text" v-model="newItemCorreo" />
          <label>Contraseña</label>
          <input type="text" v-model="newItemContraseña" />
          <button type="submit" class="btn btn-primary">Agregar</button>
        </div>
      </div>
    </form>

    <div class="card" style="width: 100%">
      <div class="card-body">
        <table id="dataTable" class="table table-striped table-bordered mt-4" style="width:100%">
          <thead>
            <tr>
              <th>id</th>
              <th>Nombre</th>
              <th>fecha</th>
              <th>Opciones</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="item in items" :key="item.id">
              <td>{{ item.id }}</td>
              <td>{{ item.name }}</td>
              <td>{{ item.created_at }}</td>
              <td>
                <!-- Agrega los enlaces para editar y eliminar el item -->
                <button class="btn btn-secondary" @click="editItem(item)" data-bs-toggle="modal"
                  data-bs-target="#exampleModal">Editar</button>
                <button class="btn btn-danger" @click="deleteItem(item)">Eliminar</button>

              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Editar</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="updateItem" class="mb-4">
              <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Nombre</label>
                <input type="text" class="form-control" v-model="newItemNameModal">

              </div>
              <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Email</label>
                <input type="email" class="form-control" aria-describedby="emailHelp" v-model="newItemCorreoModal">

              </div>
              <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <input type="password" class="form-control" v-model="newItemContraseñaModal">
              </div>
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Agregar</button>
            </form>
          </div>

        </div>
      </div>
    </div>
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
      newItemCorreo: "",
      newItemContraseña: "",
      newItemNameModal: "",
      newItemCorreoModal: "",
      newItemContraseñaModal: "",
      selectedItem: null,
    };
  },
  mounted() {
    this.fetchItems();
    console.log('Component mounted.')
  },
  methods: {
    fetchItems() {
      axios
        .get('/api/users')
        .then((response) => {
          this.items = response.data.data;
          console.log(response.data.data);
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
        .post("/api/users", { name: this.newItemName, email: this.newItemCorreo, password: this.newItemContraseña })
        .then((response) => {
          this.fetchItems();
          console.log(response);
          this.newItemName = "";
          this.newItemCorreo = "";
          this.newItemContraseña = "";

        })
        .catch((error) => {
          console.error(error);
        });
    },
    editItem(item) {
      console.log("item: ", item);
      this.newItemNameModal = item.name;
      this.newItemCorreoModal = item.email;
      this.newItemContraseñaModal = "";
      this.selectedItem = item.id;
    },
    updateItem() {
      console.log("ingresa a actualizar");
      console.log(`${this.selectedItem}`)
      console.log(this.newItemNameModal);
      console.log(this.newItemCorreoModal);

      if (this.newItemContraseñaModal == null)
        this.newItemContraseñaModal = "";
      console.log(`/api/users/${this.selectedItem}`);
      axios
        .put(`/api/users/${this.selectedItem}/update`, { name: this.newItemNameModal, email: this.newItemCorreoModal, password: this.newItemContraseñaModal })
        .then((response) => {
          this.fetchItems();
          console.log(response);
          this.newItemNameModal = "";
          this.newItemCorreoModal = "";
          this.newItemContraseñaModal = "";
        })
        .catch((error) => {
          console.error(error);
        });
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
