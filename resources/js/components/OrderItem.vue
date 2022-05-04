<template>
  <div class="bgrd b-boxord">
    <div class="OrderItem bgrd" @click="disclose = !disclose">
      <div>
        <p>Номер заказа</p>
        <h5>{{ code }}</h5>
      </div>
      <div>
        <p>Цена</p>
        <h5>{{ item.price }} руб</h5>
      </div>
      <div>
        <p>Статус</p>
        <h5 :class="statsColor">{{ item.id_order_statuse.name_status }}</h5>
      </div>
      <div>
        <button
          class="background-red"
          v-if="item.id_order_statuse.id == 1 || item.id_order_statuse.id == 2"
          @click="
            disclose = !disclose;
            edit();
          "
        >
          отменить
        </button>
        <button
          class="background-grean"
          v-if="item.id_order_statuse.id == 7 && $route.name != 'Delivery'"
          @click="$router.push('/delivery')"
        >
          доставка
        </button>
      </div>
    </div>
    <div
      class="OrderItems background-100"
      :class="h_auto"
      v-for="cart in item.json_cart.cart"
      :key="cart.id"
    >
      <h5 class="color-grean">{{ cart.name }}</h5>
      <div
        class="OrderItemsitem background-100"
        v-for="option in cart.options"
        :key="option.id"
      >
        <p>{{ option.title }}</p>
        <p>{{ option.price }}р</p>
      </div>
    </div>
  </div>
</template>
<script>
import { mask } from "../script/mask";
import { OrederEditAdmin } from "../api-routes";
export default {
  props: ["item", "getOredes"],
  data() {
    return {
      code: mask("xx-xx-xx-xx", this.item.code, true).text,
      disclose: false,
    };
  },
  methods: {
    edit() {
      const Form = new FormData();
      Form.append("id", this.item.id);
      Form.append("del", true);
      this.axios({
        method: "post",
        headers: {
          Authorization: "Bearer " + localStorage.getItem("token"),
        },
        url: OrederEditAdmin,
        data: Form,
      })
        .then((r) => {
          this.getOredes();
        })
        .catch((r) => {});
    },
  },
  computed: {
    h_auto() {
      if (this.disclose) {
        return "height-auto";
      }
      return "height-none";
    },
    statsColor() {
      if (this.item.id_order_statuse.id == 1) {
        return "color-gray-f";
      }
      if (this.item.id_order_statuse.id == 2) {
        return "color-blue";
      }
      if (this.item.id_order_statuse.id == 3) {
        return "color-oreng";
      }
      if (this.item.id_order_statuse.id == 4) {
        return "color-indigo";
      }
      if (this.item.id_order_statuse.id == 5) {
        return "color-grean";
      }
      if (this.item.id_order_statuse.id == 6) {
        return "color-red";
      }
      if (this.item.id_order_statuse.id == 7) {
        return "color-indigo";
      }
      return " ";
    },
  },
};
</script>
<style lang="scss">
.height-none {
  height: 0;
}
.height-auto {
  height: auto;
  padding: 10px;
}
.b-boxord {
  box-shadow: rgba(0, 0, 0, 0.13) 0 0 20px;
  border-radius: 5px;
  overflow: hidden;
}
.OrderItems {
  display: flex;
  margin-left: 100px;
  @media (max-width: 500px) {
    margin-left: 20px;
  }
  transition: 0.2s;
  gap: 10px;
  flex-direction: column;
  overflow: hidden;

  &item {
    display: flex;
    padding: 5px;
    border-radius: 5px;
    gap: 10px;
    justify-content: space-between;
  }
}
.OrderItem {
  border-bottom: rgba(255, 230, 230, 0.3) 2px solid;
  display: flex;
  cursor: pointer;
  align-items: center;
  flex: 1 0;
  width: auto;
  padding: 10px;
  justify-content: space-between;
  @media (max-width: 1000px) {
    flex-direction: column;
    flex: 1 1;
    align-items: flex-end;
  }

  div {
    &:nth-child(1) {
      width: 240px;
      @media (max-width: 1000px) {
        width: 100%;
      }
    }
    &:nth-child(2) {
      width: 190px;
      @media (max-width: 1000px) {
        width: 100%;
      }
    }
    &:nth-child(3) {
      width: 330px;
      @media (max-width: 1000px) {
        width: 100%;
      }
      @media (max-width: 400px) {
        h5 {
          font-size: 1.3rem;
        }
      }
    }
    &:nth-child(4) {
      width: 150px;
      @media (max-width: 1000px) {
        width: 100%;
      }
    }
    @media (max-width: 1000px) {
      width: 100%;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }
  }
}
</style>
