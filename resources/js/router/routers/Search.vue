<template >
    <div class="p-t cnt">
        <div class="Search">
            <h2>Поиск</h2>
            <div class="SearchInput border-gray">
                <input type="text" @keyup.enter="searchClick()" class="" v-model="search"
                    placeholder="Что хотите найти?" />
                <img src="../../../static/img/search.png" alt="" @click="searchClick()" />
            </div>
            <h5 v-if="this.$route.query.qwery == ''"></h5>
            <h5 v-else-if="Options.length == 0">По вашему запросу ничего не нашлось</h5>
            <h5 v-if="Options.length != 0">Услуги</h5>
            <div class="Serviceoption">
                <Option v-for="option in Options" :option="option" :addsearch="true" :item="option" :key="option.id" />
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
            });
        },
    },
};
</script>
<style lang="scss">
.Search {
    h2 {
        margin: 20px 0 10px 0;
    }

    h5 {
        margin: 20px 0 10px 0;
    }

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

