<template>
  <div class="cardSlider background-100" v-if="slider">
    <img :src="img" alt="" />
    <input type="file" name="" :id="'fileimg' + idrdm" />
    <div class="CardAdminBtn">
      <button :class="saveedit.class" @click="editdata()">
        {{ saveedit.title }}
      </button>
      <button :class="nameserv.class" @click="delitem()">
        {{ nameserv.title }}
      </button>
    </div>
  </div>
  <div class="card background-black" v-else>
    <div class="cardcontent">
      <div class="cardcontentimg background-100">
        <img :src="img" alt="" />
      </div>
      <div class="cardcontenttext CardAdmin" @click="edit = false">
        <input type="file" name="" :id="'fileimg' + idrdm" />
        <input class="color-grean" type="text" v-model="title" />
        <p class="color-gray-f" contenteditable :class="'idcnt' + idrdm">
          {{ disc }}
        </p>
      </div>
    </div>
    <div class="CardAdminBtn">
      <button :class="saveedit.class" @click="editdata()">
        {{ saveedit.title }}
      </button>
      <button :class="nameserv.class" @click="delitem()">
        {{ nameserv.title }}
      </button>

      <button
        class="background-indigo"
        v-if="servis"
        @click="$router.push('/worker/service/'+cart.id)"
      >
        Открыть
      </button>
    </div>
  </div>
</template>
<script>
import { ServiceDestroy, ServiceEdit } from "../api-routes";
export default {
  props: ["item", "open", "slider", "servis"],

  data() {
    return {
      cart: this.item,
      img: this.item.image,
      title: this.item.name,
      disc: this.item ? this.item.description : "",
      del: this.item.del,
      edit: false,
      idrdm: Math.floor(Math.random() * 100000),
    };
  },
  computed: {
    nameserv() {
      return this.del
        ? { title: "удалить", del: 0, class: "background-red" }
        : { title: "восстановить", del: 1, class: "background-grean" };
    },
    saveedit() {
      return !this.edit
        ? { title: "сохранить", class: "background-oreng" }
        : { title: "сохранено", class: "background-grean" };
    },
  },
  methods: {
    delitem() {
      const Form = new FormData();
      Form.append("id", this.cart.id);
      Form.append("del", +this.nameserv.del);
      this.axios({
        method: "post",
        headers: {
          Accept: "multipart/form-data",
          Authorization: "Bearer " + localStorage.getItem("token"),
        },
        url: ServiceDestroy,
        data: Form,
      })
        .then((r) => {
          this.del = !this.del;
        })
        .catch((r) => {});
    },
    async editdata() {
      const text = document.querySelector(".idcnt" + this.idrdm) ?? " ";
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
          this.edit = !this.edit;
          this.img = r.data.data.image;
        })
        .catch((r) => {});
    },
  },
};
</script>
<style lang="scss">
.cardSlider {
  max-width: 600px;
  flex: 2 1 400px;
  overflow: hidden;
  border-radius: 10px;
  display: flex;
  flex-direction: column;
  img {
    width: 100%;
    object-fit: cover;
  }
}
.CardAdmin {
  input[type="text"] {
    margin-top: 20px;
    font-size: 1.9rem;
    padding: 0;
    @media (max-width: 660px) {
      font-size: 1.4rem;
    }
  }
  &Btn {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
  }
}
.pos-r {
  position: relative;
  display: flex;

  flex: 2 1 400px;
  @media (max-width: 960px) {
    flex: 2 1 300px;
  }
}
.card {
  &ImgEdit {
    top: 0;
    position: absolute;
    right: 0;
    z-index: 3;
    height: 50px;
    border-radius: 10px;

    cursor: pointer;
  }
  flex: 2 1 400px;
  @media (max-width: 960px) {
    flex: 2 1 300px;
  }
  max-width: 700px;
  position: relative;
  overflow: hidden;
  border-radius: 15px;
  box-shadow: 0 0 30px rgba(0, 0, 0, 0.5);
  display: flex;
  flex-direction: column;
  justify-content: space-between;

  a {
    width: 100%;
    padding: 0;
    button {
      margin: 20px;
    }
  }
  &content {
    &text {
      padding: 15px;
      background: rgba(255, 255, 255, 0.1);
      height: 100%;
      display: flex;
      flex-direction: column;
      p {
        font-size: 1em;
      }
    }
    &img {
      overflow: hidden;
      width: 100%;
      height: 200px;
      position: relative;

      img {
        width: 100%;
        height: 200px;
        position: absolute;
        object-fit: cover;
      }
    }
  }
}
</style>
