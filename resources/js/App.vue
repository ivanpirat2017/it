<template>
  <Menu />
  <main>
    <router-view></router-view>
  </main>

  <Footer />
</template>
<script>
import Menu from "./components/Menu.vue";
import Footer from "./components/Footer.vue";
import { authCheck } from "./api-routes";
export default {
  components: {
    Menu,
    Footer,
  },
  data() {
    return {
      cartGlobal: JSON.parse(localStorage.getItem("cartBuy")) ?? [],
      authUser: {},
      role: "",
    };
  },
  methods: {

  },
  mounted() {
    authCheck()
      .then((r) => {
        return r.json();
      })
      .then((r) => {
        this.authUser = r.data;
        this.role = r.data.role;
      })
      .catch((r) => {});
  },
};
</script>
<style lang="scss">
</style>
