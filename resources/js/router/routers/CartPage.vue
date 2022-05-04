<template>
  <Loader v-if="loader" />
  <div class="cnt p-t CartPreview">
    <h2>Корзина</h2>
    <div class="CartPreviewitems">
      <h3 v-if="carts == 0" class="color-red">Пуста</h3>
      <div class="CartPreviewitemsitem background-100" v-for="item in carts" :key="item.id">
        <h5 class="color-grean">{{ item.name }}</h5>
        <div class="CartPreviewitemsitemoptions">
          <div class="background-100" v-for="option in item.options" :key="option.id">
            <p>{{ option.title }}</p>
            <p>{{ option.price }}р</p>
          </div>
        </div>
      </div>
    </div>
    <h3 class="color-gray-f" v-if="carts != 0">
      Приблизительная сумма к оплате
      <span class="color-oreng">{{ cartbuy.sum }}р</span>
    </h3>
    <div class="CartPreviewBtns" v-if="carts != 0">
      <button class="background-indigo" @click="CreateOrder()">
        Оформить заказ
      </button>
      <button class="background-red" @click="delAll()">Очистить корзину</button>
    </div>
  </div>
</template>
<script>
import { GetCart, OrederCreate } from "../../api-routes";
import Loader from "../../components/Loader.vue";
export default {
  components: {
    Loader,
  },
  data() {
    return {
      cartbuy: {},
      carts: [],
      CreateApi: false,
      loader: true,
    };
  },
  mounted() {
    this.getCart();
  },
  methods: {
    CreateOrder() {
      if (this.CreateApi) {
        return "";
      }
      this.CreateApi = true;
      const Form = new FormData();
      Form.append("json_cart", localStorage.getItem("cartBuy"));
      Form.append("price", this.cartbuy.sum);
      this.axios({
        method: "post",
        headers: {
          Authorization: "Bearer " + localStorage.getItem("token"),
        },
        url: OrederCreate,
        data: Form,
      })
        .then((r) => {
          this.delAll();
          this.$router.push("/profile");
        })
        .catch((r) => {
          this.CreateApi = false;
          this.$router.push("/login");
        });
    },
    delAll() {
      localStorage.removeItem("cartBuy");
      this.$root.cartGlobal = [];
      this.carts = [];
    },
    getCart() {
      var Form = new FormData();
      Form.append("carts", localStorage.getItem("cartBuy")??[]);
      this.axios({
        method: "post",
        url: GetCart,
        data: Form,
      })
        .then((r) => {
          this.cartbuy = r.data.data;
          this.carts = this.cartbuy.carts;
          this.loader = false;
        })
        .catch((r) => console.log(r));
    },
  },
};
</script>
<style lang="scss">
.CartPreview {
  &Btns {
    display: flex;
    gap: 10px;
    button {
    }
  }
  &items {
    display: flex;
    border-top: 2px solid rgba(128, 128, 128, 0.2);
    border-bottom: 2px solid rgba(128, 128, 128, 0.2);
    flex-wrap: wrap;
    gap: 10px;
    padding: 15px 0;
    &item {

      padding: 15px;
      border-radius: 5px;
      display: flex;
      flex: 1 1 400px;
      flex-direction: column;
      &options {
        display: flex;
        flex-direction: column;
        gap: 5px;
        div {
          display: flex;
          padding: 10px;
    
          border-radius: 5px;
          justify-content: space-between;
          P {
            &:nth-child(2) {
              padding-left: 20px;
            }
          }
        }
      }
    }
  }
}
</style>

