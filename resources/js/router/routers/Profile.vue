<template>
  <Loader v-if="loader" />
  <div class="cnt p-t Profile">
    <h2>Личный кабинет</h2>
    <div class="ProfileUser background-black">
      <h4>Карточка пользователя</h4>
      <div v-if="err.surname != null">
        <p class="color-red">{{ err.surname[0] }}</p>
      </div>

      <div class="ProfileUserItem bgrd">
        <h5>Фамилия</h5>
        <div class="border-indigo" :class="surnameColor">
          <img src="../../../static/img/user.png" alt="" />
          <input type="text" v-model="surname" />
        </div>
      </div>
      <div v-if="err.name != null">
        <p class="color-red">{{ err.name[0] }}</p>
      </div>
      <div class="ProfileUserItem bgrd">
        <h5>Имя</h5>
        <div class="border-indigo" :class="nameColor">
          <img src="../../../static/img/user.png" alt="" />
          <input type="text" v-model="name" />
        </div>
      </div>
      <div v-if="err.adress != null">
        <p class="color-red">{{ err.adress[0] }}</p>
      </div>
      <div class="ProfileUserItem bgrd">
        <h5>Адрес</h5>
        <div class="border-indigo" :class="adressColor">
          <img src="../../../static/img/address.png" alt="" />
          <input type="text" v-model="adress" />
        </div>
      </div>
      <div class="ProfileUserItem bgrd">
        <h5>Номер телефона</h5>
        <div class="border-oreng">
          <img src="../../../static/img/phone.png" alt="" />
          <input type="tel" disabled v-model="tell" />
        </div>
      </div>
      <div v-if="err.password != null">
        <p class="color-red">{{ err.password }}</p>
      </div>
      <div class="ProfileUserItem bgrd">
        <h5>Новый пароль</h5>
        <div class="border-indigo" :class="passwordColor">
          <img src="../../../static/img/padlock.png" alt="" />
          <input :type="inputPassword" v-model="password" />
          <img
            :src="openEva"
            class="c-point"
            alt=""
            @click="passwordHidden = !passwordHidden"
          />
        </div>
      </div>
      <div class="ProfileUserItem">
        <button class="background-grean" @click="EditInfo">Cохранить</button>
        <button
          class="background-indigo"
          v-if="$root.role == 'admin'"
          @click="$router.push('/worker/admin')"
        >
          Админ панель
        </button>
        <button
          class="background-oreng"
          v-if="$root.role == 'admin' || $root.role == 'worker'"
          @click="$router.push('/worker/orders')"
        >
          Панель сотрудника
        </button>
        <button class="background-red" @click="exit()">Выход</button>
      </div>
    </div>
    <div class="ProfileSearch">
      <h3>Заказы</h3>
      <select class="color-white background-100" v-model="ordercode">
        <option value="0">Все</option>
        <option value="1">Cозданные</option>
        <option value="2">Действующие</option>
        <option value="3">Выполненные</option>
        <option value="4">Отмененные</option>
      </select>
      <div class="ProfileSearchContent">
        <OrderItem
          v-for="item in filtersOrder"
          :getOredes="getOredes"
          :key="item.id"
          :item="item"
        />
      </div>
    </div>
  </div>
</template>
<script>
import Eva from "../../../static/img/view.png";
import EvaClose from "../../../static/img/eye-close.png";
import OrderItem from "../../components/OrderItem.vue";
import { mask } from "../../script/mask";
import Loader from "../../components/Loader.vue";
import { authCheck, OrederGet, ProfilEdit, Logout } from "../../api-routes";
export default {
  components: {
    OrderItem,
    Loader,
  },
  data() {
    return {
      passwordHidden: true,
      authUser: {},
      name: "",
      surname: "",
      tell: "",
      adress: "",
      password: "",
      OrderCarts: [],
      ordercode: 0,
      err: {},
      loader: true,
    };
  },
  methods: {
    exit() {
      this.axios({
        method: "delete",
        url: Logout,
        headers: {
          Authorization: "Bearer " + localStorage.getItem("token"),
        },
      })
        .then((r) => {
          this.$router.push("/login");
          this.$root.authUser = {};
          this.$root.role = "";
        })
        .catch((err) => {});
    },
    EditInfo() {
      if (this.password.length < 5 && this.password != 0) {
        this.err.password = "пароль должен быть больше 5 символов";
        return;
      }
      this.err = {};
      const Form = new FormData();
      Form.append("name", this.name);
      Form.append("surname", this.surname);
      Form.append("adress", this.adress);
      Form.append("tell", this.phone);
      Form.append("password", this.password);
      this.axios({
        method: "post",
        url: ProfilEdit,
        headers: {
          Authorization: "Bearer " + localStorage.getItem("token"),
        },
        data: Form,
      })
        .then((r) => {
          this.password = "";
        })
        .catch((err) => {
          if (err.response) {
            this.err = err.response.data.errors;
          }
        });
    },
    getOredes() {
      this.axios({
        method: "get",
        headers: {
          Authorization: "Bearer " + localStorage.getItem("token"),
        },
        url: OrederGet,
      })
        .then((r) => {
          this.OrderCarts = r.data.data;
          this.loader = false;
        })
        .catch((r) => this.getOredes());
    },
  },
  mounted() {
    this.getOredes();
    if (this.tell == "") {
      authCheck()
        .then((r) => {
          return r.json();
        })
        .then((r) => {
          this.authUser = r.data;
          this.name = this.authUser.name ?? "";
          this.surname = this.authUser.surname ?? "";
          this.tell = mask("+x (xxx) xxx-xx-xx", this.authUser.tell ?? "").text;
          this.adress = this.authUser.adress ?? "";
          this.$root.authUser = r.data;
          this.$root.role = r.data.role;
        })
        .catch((r) => {});
    }
  },
  computed: {
    filtersOrder() {
      return this.OrderCarts.filter((item) => {
        const id = item.id_order_statuse.id;
        if (this.ordercode == 0) {
          return item;
        }
        if (this.ordercode == 1) {
          if (id == 1) {
            return item;
          }
        }
        if (this.ordercode == 2) {
          if (id == 2 || id == 3 || id == 4) {
            return item;
          }
        }
        if (this.ordercode == 3) {
          if (id == 5 || id == 7) {
            return item;
          }
        }
        if (this.ordercode == 4) {
          if (id == 6) {
            return item;
          }
        }
      });
    },

    nameColor() {
      if (this.name != this.authUser.name) {
        return "border-red";
      }
      return " ";
    },
    surnameColor() {
      if (this.surname != this.authUser.surname) {
        return "border-red";
      }
      return " ";
    },
    adressColor() {
      if (this.adress != this.authUser.adress) {
        return "border-red";
      }
      return " ";
    },
    passwordColor() {
      if (this.password.length != 0) {
        return "border-red";
      }
      return " ";
    },
    openEva() {
      if (this.passwordHidden) {
        return Eva;
      }
      return EvaClose;
    },
    inputPassword() {
      if (this.passwordHidden) {
        return "password";
      }
      return "text";
    },
  },
};
</script>
<style lang="scss">
.Profile {
  &User {
    border-radius: 20px;
    max-width: 800px;
    padding: 20px;
    &Item {
      margin: 20px 0;
      padding: 10px;
      border-radius: 10px;
      display: flex;
      align-items: center;
      @media (max-width: 650px) {
        flex-direction: column;
        align-items: flex-start;
        margin: 10px 0;
      }
      button {
        margin-left: 10px;
        @media (max-width: 650px) {
          margin-left: 0;
          margin-bottom: 10px;
        }
      }
      div {
        border-radius: 5px;
        display: flex;
        padding: 10px;
        align-items: center;
        width: 100%;
        @media (max-width: 650px) {
          width: 95%;
        }
        background: rgba(255, 255, 255, 0.05);
        box-shadow: rgba(0, 0, 0, 0.288) 0 0 20px;
        img {
          height: 30px;
          filter: invert(0.5);
        }
        input {
          min-width: 200px;
        }
      }
      h5 {
        padding-right: 20px;
        width: 350px;
        font-size: 1.3em;
        @media (max-width: 650px) {
          padding-right: 0;
          padding-bottom: 10px;
        }
      }
    }
  }
  &Search {
    padding-top: 30px;
    width: 100%;
    select {
      padding: 5px 10px;
      outline: none;
      border: none;
      border-radius: 5px;
      option {
        border-radius: 0;
        color: black;
        font-family: "Montserrat", sans-serif;
        font-weight: 400;
      }
    }
    &Write {
      display: flex;
      align-items: center;
      button {
        max-width: 200px;
        min-width: 150px;
      }
      input {
        display: flex;
        margin-right: 20px;
        height: 32px;
      }
      width: 100%;
    }
    &Content {
      padding-top: 20px;
      display: flex;
      flex-wrap: wrap;
      flex-direction: column;
      gap: 15px;
    }
  }
}
.c-point {
  cursor: pointer;
}
</style>
