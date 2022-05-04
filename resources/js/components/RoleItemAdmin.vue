<template>
  <div class="RolePeoplesItem background-100">
    <p>{{ user.surname }}</p>
    <p>{{ user.name }}</p>
    <p>{{ user.tell }}</p>
    <select class="color-white background-100" v-model="role">
      <option value="1">Клиент</option>
      <option value="2">Работник</option>
      <option value="3">Админ</option>
    </select>
    <button @click="edit()" :class="btnEditInfoClass" class="background-grean">
      {{ btnEditInfotext }}
    </button>
  </div>
</template>
<script>
import { EditRoleId } from "../api-routes";

export default {
  props: ["user"],
  data() {
    return {
      role: this.user.roleid,
      clickBtnEdit: false,
    };
  },
  watch: {
    role() {
      this.clickBtnEdit = false;
    },
  },
  methods: {
    edit() {
      const Form = new FormData();
      Form.append("id", this.user.id);
      Form.append("id_role", this.role);
      this.axios({
        method: "post",
        headers: {
          Authorization: "Bearer " + localStorage.getItem("token"),
        },
        url: EditRoleId,
        data: Form,
      })
        .then((r) => {
          this.clickBtnEdit = true;
        })
        .catch((r) => {});
    },
  },
  computed: {
    btnEditInfoClass() {
      if (this.clickBtnEdit) {
        return "background-grean";
      }
      return "background-gray-blue";
    },
    btnEditInfotext() {
      if (this.clickBtnEdit) {
        return "изменено";
      }
      return "подтвердить";
    },
  },
};
</script>
<style lang="scss">
.RolePeoplesItem {
  display: flex;

  padding: 10px;
  border-radius: 2px;
  flex: 0 0 400px;
  gap: 10px;
  align-items: center;
  @media (max-width: 700px) {
    flex-direction: column;
      flex: 0 0 100px;
        align-items: flex-start;
  }
  p {
    font-size: 1em;
  }
  select {
    padding: 5px 5px;
    outline: none;
    font-size: 1em;
    border: none;
    border-radius: 5px;
    option {
      border-radius: 0;
      font-size: 1em;
    }
  }
}
</style>
