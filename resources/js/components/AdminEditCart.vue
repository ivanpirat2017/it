<template>
  <div class="AdminEditCart background-black">
    <div class="AdminEditCartitem">
      <p class="AdminEditCartitemClose" @click="openEditclick()">x</p>
      <h4 v-if="!id_type">Редактировать карточку</h4>
      <h4 v-else>Создать карточку</h4>
      <h5>название</h5>
      <input type="text" v-model="title" />
      <h5>описание</h5>
      <p
        contenteditable
        class="AdminEditCartitemEdittext"
        :class="'idcnt' + idrdm"
      >
        {{ disc }}
      </p>
      <h5>изображение</h5>
      <input type="file" name="" :id="'fileimg' + idrdm" />
      <button class="background-grean" @click="id_type ? create() : edit()">
        {{ nameserv }}
      </button>
      <button class="background-red" @click="delitem()" v-if="!id_type">
        Удалить
      </button>
    </div>
  </div>
</template>
<script>
import { ServiceEdit, ServiceCreate } from "../api-routes";
export default {
  props: ["openEditclick", "item", "cartUpdate", "id_type", "delitem"],
  data() {
    return {
      title: this.item ? this.item.name : "",
      disc: this.item ? this.item.description : "",
      idrdm: Math.floor(Math.random() * 100000),
    };
  },
  computed: {
    nameserv() {
      return this.id_type ? "создать" : "сохранить";
    },
  },
  methods: {
    async create() {
      const text = document.querySelector(".idcnt" + this.idrdm);
      const fileimg = document.querySelector("#fileimg" + this.idrdm);
      const Form = new FormData();
      await Form.append("id_type", this.id_type);
      await Form.append("name", this.title);
      await Form.append("description", text.textContent);
      await Form.append("image", fileimg.files[0]);

      console.log(text);
      await this.axios({
        method: "post",
        headers: {
          Accept: "multipart/form-data",
          Authorization: "Bearer " + localStorage.getItem("token"),
        },
        url: ServiceCreate,
        data: Form,
      })
        .then((r) => {
          this.cartUpdate();
          this.openEditclick();
        })
        .catch((r) => {});
    },
    async edit() {
     const text = document.querySelector(".idcnt" + this.idrdm);
      const fileimg = document.querySelector("#fileimg" + this.idrdm);
      const Form = new FormData();
      await Form.append("id", this.item.id);
      await Form.append("name", this.title);
      await Form.append("description", text.textContent);
      await Form.append("image", fileimg.files[0]);
      await this.axios({
        method: "post",
        headers: {
          Accept: "multipart/form-data",
          Authorization: "Bearer " + localStorage.getItem("token"),
        },
        url: ServiceEdit,
        data: Form,
      })
        .then((r) => {
          this.cartUpdate(r.data.data);
          this.openEditclick();
        })
        .catch((r) => {});
    },
  },
};
</script>
<style lang="scss">
.AdminEditCart {
  position: absolute;
  left: 0;
  top: 0;
  width: 100%;
  display: flex;
  align-items: flex-start;
  overflow: hidden;
  z-index: 4;
  &item {
    width: 100%;
    min-width: 300px;
    box-shadow: rgba(255, 255, 255, 0.185) 0 0 100px;
    display: flex;
    flex-direction: column;

    padding: 15px;
    border-radius: 10px;
    min-height: 200px;
    position: relative;
    button {
      margin-bottom: 20px;
    }
    &Edittext {
      width: 90%;
      min-height: 50px;
      padding: 5px;
      border-radius: 10px;
      margin: 15px 0;
      border: gray 2px solid;
      outline: none;
    }
    &Close {
      position: absolute;
      top: 0;
      right: 0;
      padding: 5px;
      height: 20px;
      width: 20px;
      border-radius: 100%;
      background: rgb(59, 59, 59);
      font-weight: 700;
      font-size: 1.4em;
      display: flex;
      cursor: pointer;
      align-items: center;
      justify-content: center;
      text-align: center;
      color: red;
    }
    input {
      width: 90%;
      padding: 10px;
      margin: 15px 0;
      border: gray 2px solid;
    }
  }
}
</style>
