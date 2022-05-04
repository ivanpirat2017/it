<template>
  <div class="Role">
    <div class="RoleSearch">
      <input
        type="text"
        class="border-gray"
        placeholder="Найти пользователя ?"
        v-model="search"
        @input="getUsersAdmin"
      />
    </div>
    <div class="RolePeoples">
      <RoleItemAdmin v-for="user in users" :key="user.id" :user='user' />
    </div>
  </div>
</template>
<script>
import RoleItemAdmin from "../../../components/RoleItemAdmin.vue";
import { SearchAmdimRole } from "../../../api-routes";

export default {
  components: {
    RoleItemAdmin,
  },
  data() {
    return {
      search: "",

      users: [],
    };
  },
  methods: {
    getUsersAdmin() {
      this.axios({
        method: "get",
        headers: {
          Authorization: "Bearer " + localStorage.getItem("token"),
        },
        url: SearchAmdimRole+'?qwery='+this.search,
      })
        .then((r) => {
            console.log( r.data.data)
          this.users = r.data.data;
        })
        .catch((r) => {});
    },
  },
};
</script>
<style lang="scss">
.Role {
  width: 100%;
  &Search {
    width: 100%;
    margin: 10px 0;
    display: flex;
    input {
      display: flex;
      margin-right: 20px;
      height: 32px;
    }
  }
  &Peoples {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
  }
}
</style>
