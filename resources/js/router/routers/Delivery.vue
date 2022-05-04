<template >
  <Loader v-if="loader" />
  <div class="Delivery cnt p-t">
    <h2>Доставка</h2>
    <h5 class="color-red">доставку товаров не осуществляем.</h5>
    <p class="color-blue">
      Выдача производится по адресу - Октябрьская ул., 193, Прямицыно, Курская
      обл
    </p>
    <div class="ProfileSearch">
      <h3>Заказы</h3>
      <div class="ProfileSearchContent">
        <h5 class="color-oreng" v-if="filtersOrder.length == 0">
          Заказов готовых к выдачи нет
        </h5>
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
import OrderItem from "../../components/OrderItem.vue";

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
  },
  computed: {
    filtersOrder() {
      return this.OrderCarts.filter((item) => {
        const id = item.id_order_statuse.id;
        if (id == 7) {
          return item;
        }
      });
    },
  },
};
</script>
<style lang="scss">
</style>


