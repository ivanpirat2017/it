<template>
  <div class="AdminWorkerComment background-black">
    <div class="AdminWorkerCommenContent">
      <div class="AdminWorkerCommentName">
        <p class="color-oreng">
          {{ comment.user.surname }} {{ comment.user.name }}
        </p>
      </div>
      <div class="AdminWorkerCommentText">
        <p class="color-gray-f">
          {{ comment.text_comment }}
        </p>
      </div>
    </div>
    <div class="AdminWorkerCommentBtn">
      <button class="background-grean" @click="edit(0, 1)">+</button>
      <button class="background-red" @click="edit(1, 0)">del</button>
    </div>
  </div>
</template>
<script>
import { CommentEdit } from "../api-routes";
export default {
  props: ["comment", "getCommentAdmin"],
  data() {
    return {};
  },
  methods: {
    edit(del, push) {
      const Form = new FormData();
      Form.append("id", this.comment.id);
      Form.append("del", del);
      Form.append("approved", push);
      this.axios({
        method: "post",
        headers: {
          Authorization: "Bearer " + localStorage.getItem("token"),
        },
        url: CommentEdit,
        data: Form,
      })
        .then((r) => {
          this.getCommentAdmin();
        })
        .catch((r) => {});
    },
  },
};
</script>
<style lang="scss">
.AdminWorkerComment {
  display: flex;
  border-radius: 5px;
  flex: 1 1 100%;
  display: flex;
  padding: 10px;
  @media (max-width: 500px) {
    flex-direction: column;
  }
  justify-content: space-between;
  &Content {
    display: flex;
    flex-direction: column;
  }
  &Btn {
    padding: 5px;
    align-items: center;
    display: flex;
    flex-direction: column;
    @media (max-width: 500px) {
      justify-content: space-around;
      flex-direction: row;
    }
    button {
      margin: 5px;
      height: 50px;
      width: 60px;
      @media (max-width: 500px) {
        height: auto;
        width: 30%;
      }
    }
  }
  &Name {
    display: flex;
    p {
      padding-right: 10px;
    }
  }
}
</style>
