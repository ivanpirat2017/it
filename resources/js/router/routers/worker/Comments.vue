
<template>
  <div>
    <h4>Комментарии</h4>
    <h5 class="color-grean" v-if="Comments.length==0">Ура Комментариев нет</h5>
    <div class="AdminWorkerComments">
      <AdminEditComment :getCommentAdmin='getCommentAdmin' v-for="comment in Comments" :key="comment.id" :comment='comment' />
    </div>
  </div>
</template>
<script>
import AdminEditComment from "../../../components/AdminEditComment.vue";
import { CommentShowAdmin } from "../../../api-routes";
export default {
  components: {
    AdminEditComment,
  },
  data() {
    return {
      Comments: [],
    };
  },
  mounted() {
    this.getCommentAdmin();
  },
  methods: {
    getCommentAdmin() {
      this.axios({
        method: "get",
        headers: {
          Authorization: "Bearer " + localStorage.getItem("token"),
        },
        url: CommentShowAdmin,
      })
        .then((r) => {
          this.Comments = r.data.data;
        })
        .catch((r) => {});
    },
  },
};
</script>
<style lang="scss">
.AdminWorkerComments {
  display: flex;
  flex-direction: column;
  gap: 20px;
}
</style>

