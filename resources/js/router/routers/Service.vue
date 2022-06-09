<template>
    <Loader v-if="loader" />
    <div class="p-t cnt">
        <div class="Service">
            <div class="ServiceImg">
                <img :src="Servic.image" :key="Servic.id" />
            </div>
            <h2>{{ Servic.name }}</h2>
            <p class="color-gray-f">{{ Servic.description }}</p>
            <h4>Выберите нужный список услуг</h4>
            <div class="ServiceSelect">
                <select v-model="sortnum" class="background-black color-gray-f">
                    <option value="1">популярные</option>
                    <option value="2">цена по возрастанию</option>
                    <option value="3">цена по убыванию</option>
                </select>
            </div>
            <div class="Serviceoption">
                <Option @click="info = true" v-for="option in sortArr" :option="option" :setCart="setCart"
                    :item="option" :key="option.id" />
            </div>
            <div class="ServiceInfo">
                <button class="background-oreng" v-if="info" @click="$router.push('/cart')">
                    Перейти в корзину, для оформления заказа
                </button>
            </div>

        </div>
    </div>
</template>
<script>
import {
    ServiceIndex_ID,

} from "../../api-routes";
import Option from "../../components/Option.vue";
import AdminOption from "../../components/AdminOption.vue";
import Loader from "../../components/Loader.vue";
export default {
    components: {
        Option,
        AdminOption,
        Loader,
    },
    data() {
        return {
            Servic: {},
            Options: [],
            cartOption: [],
            cartOptionSort: [],
            sortnum: 1,
            info: false,

            loader: true,

        };
    },
    computed: {
        sortArr() {
            if (this.sortnum == 1) {
                return this.Options;
            }
            if (this.sortnum == 2) {
                function compareNumeric(a, b) {
                    if (a.price > b.price) return 1;
                    if (a.price == b.price) return 0;
                    if (a.price < b.price) return -1;
                }
                return this.cartOptionSort.sort(compareNumeric);
            }
            if (this.sortnum == 3) {
                function compareNumeric(a, b) {
                    if (a.price > b.price) return -1;
                    if (a.price == b.price) return 0;
                    if (a.price < b.price) return 1;
                }
                return this.cartOptionSort.sort(compareNumeric);
            }
        },
    },
    methods: {

        getOptions() {
            this.axios.get(ServiceIndex_ID + this.$route.params.id).then((r) => {
                this.cartOption = [];
                JSON.parse(localStorage.getItem("cartBuy")) ??
                    [].forEach((item) => {
                        console.log(item.id_service);
                        if (item.id_service == this.$route.params.id) {
                            this.cartOption =
                                JSON.parse(localStorage.getItem("carts_id" + r.data.data.id)) ??
                                [];
                        }
                    });
                if (JSON.parse(localStorage.getItem("cartBuy")) ?? [].length == 0) {
                    this.cartOption = [];
                }

                this.Servic = r.data.data;
                this.Options = this.Servic.get_options;
                this.cartOptionSort = [...this.Options];
                this.loader = false;
            });
        },
        createCartObj(id) {
            this.$root.cartGlobal = JSON.parse(localStorage.getItem("cartBuy")) ?? [];
            this.$root.cartGlobal.forEach((item, i) => {
                if (item.id_service == id) {
                    this.$root.cartGlobal.splice(i, 1);
                }
            });
            if (!this.cartOption.length == 0) {
                this.$root.cartGlobal.push({
                    id_service: id,
                    service_options: this.cartOption,
                });
            }
            localStorage.setItem("cartBuy", JSON.stringify(this.$root.cartGlobal));
        },
        setCart(i, add = false) {
            if (this.cartOption.includes(i)) {
                if (add) {
                    this.cartOption.splice(this.cartOption.indexOf(i), 1);
                } else {
                    return true;
                }
            } else {
                if (add) {
                    this.cartOption.push(i);
                } else {
                    return false;
                }
            }
            localStorage.setItem(
                "carts_id" + this.Servic.id,
                JSON.stringify(this.cartOption)
            );
            this.createCartObj(this.Servic.id);
        },
    },
    mounted() {
        this.getOptions();

    },
};
</script>
<style lang="scss" >
.infocount {
    border-radius: 10px;
    padding: 10px;
    animation-iteration-count: 1;
    animation: transformScale 0.3s;

    @keyframes transformScale {
        from {
            transform: scale(0.1);
        }

        to {
            transform: scale(1);
        }
    }

    h5 {
        font-size: 1.2rem;
    }
}

.Service {
    background: rgba(255, 255, 255, 0.05);
    padding: 0 10px;
    border-radius: 10px;
    display: flex;
    flex-direction: column;

    &Info {
        padding: 20px 0;

        @media (max-width: 600px) {
            position: fixed;
            width: 100vw;
            bottom: 0;
            left: 0;
            z-index: 2;
            padding: 0;
        }
    }

    &Comment {
        margin: 20px 0;
        border-radius: 10px;
        width: 98%;
        padding: 1%;
        @media (max-width: 800px) {
            width: 94%;
            padding: 3%;
        }
        display: flex;
        flex-direction: column;
        &items {
            display: flex;
            flex-direction: column;
            gap: 10px;
            &item {
                display: flex;
                border-radius: 5px;
                flex: 1 1 100%;
                display: flex;
                padding: 10px;
                flex-direction: column;

                &Name {
                    display: flex;

                    p {
                        padding-right: 10px;
                    }
                }
            }
        }

        &Write {
            display: flex;
            flex-direction: column;
            align-items: flex-end;

            p {
                min-height: 100px;
                width: 98%;
                padding: 1%;

                @media (max-width: 800px) {
                    width: 94%;
                    padding: 3%;
                    min-height: 100px;
                }

                outline: none;
                border-radius: 10px;
                transition: 0.4s;
            }

            button {
                margin-top: 5px;
                max-width: 160px;
            }
        }
    }

    &Select {
        padding: 15px 0;
        display: flex;
        justify-content: flex-end;

        select {
            padding: 5px 10px;
            outline: none;
            border: none;
            border-radius: 5px;

            option {
                border-radius: 0;
            }
        }
    }

    &option {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    &Img {
        width: 100%;

        img {
            width: 100%;
            height: 300px;
            object-fit: cover;
            border-radius: 5px;
        }
    }
}
</style>

