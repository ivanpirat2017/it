<template >
  <div class="AdminOrderCart background-black">
    <h4 class="color-oreng">
      <span class="color-gray-f">Заказ :</span> {{ code }}
    </h4>
    <h5 class="color-white">
      <span class="color-gray-f">Клиент</span> {{ Order.user.surname }}
      {{ Order.user.name }} - {{ tell }}
    </h5>
    <h5 class="color-white">
      <span class="color-gray-f">Проживает</span> {{ Order.user.adress }}
    </h5>
    <div
      class="AdminOrderCartItem background-100"
      v-for="cart in Order.json_cart.cart"
      :key="cart.id"
    >
      <h5 class="color-grean">{{ cart.name }}</h5>
      <div class="AdminOrderCartItemoptions ">
        <div class="background-100" v-for="option in cart.options" :key="option.id">
          <p>{{ option.title }}</p>
          <p>{{ option.price }}р</p>
        </div>
      </div>
    </div>
    <h5>предварительная сумма {{ Order.price }}р</h5>
    <div class="AdminOrderCartEdit">
      <select class="color-white background-100" v-model="statusCode">
        <option value="1">создан</option>
        <option value="2">обработан</option>
        <option value="3">ожидайте мастера</option>
        <option value="4">мастер выехал</option>
        <option value="5">заказ выполнен</option>
        <option value="6">заказ отменен</option>
        <option value="7">заберите заказ</option>
      </select>
      <button @click="edit" :class="btnEditInfoClass">
        {{ btnEditInfotext }}
      </button>
    </div>
  </div>
</template>
<script>
import { OrederEditAdmin } from "../api-routes";
import { mask } from "../script/mask";
export default {
  props: ["Order", "getOrdersAdmin"],
  data() {
    return {
      statusCode: this.Order.id_order_statuse.id,
      clickBtnEdit: false,
      tell: mask("+x (xxx) xxx-xx-xx", this.Order.user.tell).text,
      code: mask("xx-xx-xx-xx", this.Order.code, true).text,
    };
  },
  watch: {
    statusCode() {
      this.clickBtnEdit = false;
    },
  },
  computed: {
    btnEditInfotext() {
      if (this.clickBtnEdit) {
        return "изменено";
      }
      return "подтвердить";
    },
    btnEditInfoClass() {
      if (this.clickBtnEdit) {
        return "background-grean";
      }
      return "background-gray-blue";
    },
  },
  methods: {
    edit() {
      const Form = new FormData();
      Form.append("id", this.Order.id);
      Form.append("id_order_statuse", this.statusCode);
      this.axios({
        method: "post",
        headers: {
          Authorization: "Bearer " + localStorage.getItem("token"),
        },
        url: OrederEditAdmin,
        data: Form,
      })
        .then((r) => {
          this.clickBtnEdit = true;
          this.getOrdersAdmin();
        })
        .catch((r) => {});
    },
  },
};
</script>
<style lang="scss">
.AdminOrderCart {
  padding: 10px;
  border-radius: 5px;
  &Edit {
    padding: 15px 0;
    display: flex;
    justify-content: flex-end;
    @media (max-width: 450px) {
      flex-direction: column;
    }
    button {
      margin-left: 10px;
      @media (max-width: 450px) {
        margin-left: 0px;
        margin-top: 10px;
      }
    }
    select {
      padding: 5px 10px;
      outline: none;
      border: none;
      border-radius: 10px;
      option {
        border-radius: 0;
      }
    }
  }
  &Item {

    padding: 5px;
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
</style>
