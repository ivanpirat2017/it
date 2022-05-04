<template >
  <div class="p-t cnt">
    <div class="Search">
      <h2>Поиск</h2>
      <div class="SearchInput border-gray">
        <input type="text" @keyup.enter="searchClick()" class="" v-model="search" />
        <img
          src="../../../static/img/search.png"
          alt=""
          @click="searchClick()"

        />
      </div>
      <h5  v-if="comments.length == 0&&Options.length == 0">По вашему запросу ничего не нашлось</h5>
      <h4 v-if="Options.length != 0">Услуги</h4>
      <div class="Serviceoption">
        <Option
          v-for="option in Options"
          :option="option"
          :addsearch="true"
          :item="option"
          :key="option.id"
        />
      </div>
      <h4 v-if="comments.length != 0">Комментарии</h4>
      <div class="ServiceCommentitems">
        <div
          class="ServiceCommentitemsitem background-black"
          v-for="comment in comments"
          :key="comment.id"
        >
          <div class="ServiceCommentitemsitemText">
            <p class="color-gray-f">{{ comment.textComment }}</p>
          </div>
          <div class="s">
            <router-link :to="'/service/' + comment.getService.id">{{
              comment.getService.name
            }}</router-link>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { SearchData } from "../../api-routes";
import Option from "../../components/Option.vue";
export default {
  components: {
    Option,
  },
  data() {
    return {
      Options: [],
      search: this.$route.query.qwery ?? "",
      comments: [],
    };
  },
  mounted() {
    this.getOptions();
  },
  methods: {
    searchClick() {
      this.getOptions();
    },
    getOptions() {
      this.axios.get(SearchData + "?qwery=" + this.search).then((r) => {
        this.$router.push("/search?qwery=" + this.search);
        this.Options = r.data.data.ServiceOption ?? [];
        this.comments = r.data.data.Comment ?? [];
      });
    },
  },
};
</script>
<style lang="scss">
.Search {
  &Input {
    display: flex;
    height: 40px;
    gap: 15px;
    padding: 10px;
    border-radius: 10px;
    input {
      padding: 0;
      height: 100%;
    }
    img {
      cursor: pointer;
      transition: 0.2s;
      &:hover {
        transform: scale(1.1);
      }
    }
  }
}
</style>

