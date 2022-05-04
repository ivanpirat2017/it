<template >
  <div class="AddMainContent">
    <h4>Главная страница</h4>

    <div class="AddMainContentItem">
      <h3>Слайдер</h3>
      <button @click="create(3)" class="background-oreng AddMainContentItemBtn">
        создать слайд
      </button>
      <div class="AddMainContentItemItems">
        <Card
          v-for="item in Sliders"
          :item="item"
          :slider="true"
          :key="item.id"
        />
      </div>
    </div>
    <div class="AddMainContentItem">
      <h3>карточки услуг компании</h3>
      <button @click="create(1)" class="background-oreng AddMainContentItemBtn">
        Услуги компании
      </button>
      <div class="AddMainContentItemItems">
        <Card
          v-for="item in OurServices"
          :item="item"
          :servis="true"
          :key="item.id"
        />
      </div>
    </div>
    <div class="AddMainContentItem">
      <h3>карточки преимуществ компании</h3>
      <button @click="create(2)" class="background-oreng AddMainContentItemBtn">
        Преимущества компании
      </button>
      <div class="AddMainContentItemItems">
        <Card v-for="item in WhyChoose" :item="item" :key="item.id" />
      </div>
    </div>
  </div>
</template>
<script>
import AdminEditCart from "../../../components/AdminEditCart.vue";
import { ServiceShowAdmin_ID, ServiceCreate } from "../../../api-routes";
import Card from "../../../components/CardAdmin.vue";
export default {
  components: {
    AdminEditCart,
    Card,
  },
  data() {
    return {
      OurServices: [],
      WhyChoose: [],
      Sliders: [],
      loader: true,
    };
  },
  mounted() {
    this.cartUpdate();
  },
  methods: {
    async create(id) {
      const Form = new FormData();
      await Form.append("id_type", id);
      await Form.append("name", "Название");
      await Form.append("description", "Описание");

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
        })
        .catch((r) => {});
    },
    getServiceShow1() {
      this.axios
        .get(ServiceShowAdmin_ID + 1)
        .then((r) => {
          this.OurServices = r.data.data;
        })
        .catch((r) => this.getServiceShow1());
    },
    getServiceShow2() {
      this.axios
        .get(ServiceShowAdmin_ID + 2)
        .then((r) => {
          this.WhyChoose = r.data.data;
          this.loader = false;
        })
        .catch((r) => this.getServiceShow2());
    },
    getServiceShow3() {
      this.axios
        .get(ServiceShowAdmin_ID + 3)
        .then((r) => {
          this.Sliders = r.data.data;
          this.loader = false;
        })
        .catch((r) => this.getServiceShow3());
    },
    cartUpdate() {
      this.getServiceShow1();
      this.getServiceShow2();
      this.getServiceShow3();
    },
  },
};
</script>
<style lang="scss">
.AddMainContent {
  &Item {
    padding: 20px 0;
    &Btn {
      margin: 20px 0;
    }
    &Items {
      display: flex;
      flex-wrap: wrap;
      gap: 15px;
    }
  }
}
</style>
