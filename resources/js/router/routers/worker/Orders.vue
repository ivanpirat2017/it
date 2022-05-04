
<template>
  <div class="AdminWorkerOrder">
    <h4>Заказы</h4>
    <h5  >Поиск</h5>
    <div class="AdminWorkerOrderWrite">
      <input
        type="text"
        class="border-gray"
        placeholder="Что хотите найти ?"
        v-model="search"
      />
    </div>
    <select class="color-white background-100" v-model="statusCode">
      <option value="1">создан</option>
      <option value="2">обработан</option>
      <option value="3">ожидайте мастера</option>
      <option value="4">мастер выехал</option>
      <option value="5">заказ выполнен</option>
      <option value="6">заказ отменен</option>
      <option value="7">заберите заказ</option>
    </select>
    <h5 class="color-grean" v-if="filtersOrder.length == 0">Ура Заказов нет</h5>
    <div class="AdminWorkerOrderCart">
      <AdminOrderCart
        :getOrdersAdmin="getOrdersAdmin"
        v-for="Order in filtersOrder"
        :key="Order.id"
        :Order="Order"
      />
    </div>
  </div>
</template>
<script>
import AdminOrderCart from "../../../components/AdminOrderCart.vue";
import { OrederGetAdmin } from "../../../api-routes";
export default {
  components: {
    AdminOrderCart,
  },
  data() {
    return {
      Orders: [],
      statusCode: 1,
      search: "",
    };
  },
  computed: {
    filtersOrder() {
      if (this.search != "") {
        return this.Orders.filter((item) => {
          var pattern = new RegExp("" + this.search.toLowerCase() + ".*");
          if (item.user.name.toLowerCase().match(pattern)) {
            return item;
          }
          if (item.user.surname.toLowerCase().match(pattern)) {
            return item;
          }
          if (item.user.tell.toLowerCase().match(pattern)) {
            return item;
          }
          if (item.user.adress.toLowerCase().match(pattern)) {
            return item;
          }
          if (String(item.price).toLowerCase().match(pattern)) {
            return item;
          }
          if (String(item.code).toLowerCase().match(pattern)) {
            return item;
          }
          const arrcart = item.json_cart.cart.filter((element) => {
            if (element.name.toLowerCase().match(pattern)) {
              return element;
            } else {
              const options = element.options.filter((options) => {
                if (String(options.title).toLowerCase().match(pattern)) {
                  return item;
                }
                if (String(options.price).toLowerCase().match(pattern)) {
                  return item;
                }
              });
              if (options.length != 0) {
                return item;
              }
            }
          });
          if (arrcart.length != 0) {
            return item;
          }
        });
      } else {
        return this.Orders.filter((item) => {
          if (item.id_order_statuse.id == this.statusCode) {
            return item;
          }
        });
      }
    },
  },
  mounted() {
    this.getOrdersAdmin();
  },
  methods: {
    getOrdersAdmin() {
      this.axios({
        method: "get",
        headers: {
          Authorization: "Bearer " + localStorage.getItem("token"),
        },
        url: OrederGetAdmin,
      })
        .then((r) => {
          this.Orders = r.data.data;
        })
        .catch((r) => {});
    },
  },
};
</script>
<style lang="scss">
.AdminWorkerOrder {
  display: flex;
  flex-direction: column;
  gap: 10px;
  &Write {
    margin: 10px 0;
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
  &Cart {
    display: flex;
    flex-direction: column;
    gap: 20px;
  }

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
}
</style>

