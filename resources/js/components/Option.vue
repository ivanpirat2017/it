<template >
    <div v-if="delcart" class="ServiceoptionCart background-100"
        :class="{ 'border-grean': !click, 'border-red': click }">
        <div class="ServiceoptionCartCircl background-black" v-if="!addsearch" @click="clickOpnion()">
            <h4 class="color-grean m-b-2" v-if="!click">+</h4>
            <h4 class="color-red m-b-5" v-else>-</h4>
        </div>
        <div class="ServiceoptionCartCircl background-black" v-else>
            <router-link :to="'/service/' + option.id_service">
                <h4 class="color-grean m-b-2">+</h4>
            </router-link>
        </div>
        <div class="ServiceoptionCartText">
            <p>{{ option.title }}</p>
            <div>
                <img v-if="option.delivery" src="../../static/img/delivery.png" alt="">
                <p>{{ option.price }} Р</p>

            </div>

        </div>
        <button class="background-red" v-if="adm" @click="clickclose()">
            X
        </button>
        <Popup v-if="del" :clickclose="clickclose" :title="'Удалить услугу'"
            :text="'Вы действительно хотите удалить услугу ?'" :namebtn="'Удалить'" :funbtn="dell" />
    </div>
</template>
<script>
import Popup from "../components/Popup.vue";
import { ServiceOptionDel } from "../api-routes";
export default {
    components: {
        Popup,
    },
    props: ["option", "setCart", "addsearch", 'adm'],
    data() {
        return {
            click: false,
            del: false,
            delcart: true,
        };
    },
    mounted() {
        if (!this.addsearch) {
            this.click = this.setCart(this.option.id);
        }
    },
    methods: {
        dell() {
            const Form = new FormData();
            Form.append("id", this.option.id);
            this.axios({
                method: "post",
                headers: {
                    Authorization: "Bearer " + localStorage.getItem("token"),
                },
                url: ServiceOptionDel,
                data: Form,
            })
                .then((r) => {
                    this.delcart = false;
                })
                .catch((r) => { });
        },
        clickclose() {
            this.del = !this.del;
        },
        clickOpnion() {
            this.click = !this.click;
            this.setCart(this.option.id, true);
        },
    },
};
</script>
<style lang="scss">
.ServiceoptionCart {
    transition: 0.5s;
    flex: 1 1 100%;

    justify-content: space-between;
    align-items: center;
    padding: 5px;
    border-radius: 10px;
    display: flex;
    gap: 15px;

    &Text {
        display: flex;
        justify-content: space-between;
        width: 100%;
        gap: 15px;

        div {
            display: flex;

            img {
                height: 30px;
            }

            gap: 5px;

            P {
                white-space: nowrap;
            }
        }

        @media (max-width: 450px) {
            flex-direction: column;
            gap: 5px;
        }

        P {
            &:nth-child(1) {}


        }
    }

    &Circl {
        padding: 5px;

        display: flex;
        align-items: center;
        flex-shrink: 0;
        justify-content: center;
        cursor: pointer;
        height: 25px;
        width: 25px;
        border-radius: 100%;
        font-size: 2em;
        text-align: center;

        h4 {
            padding: 0;
            text-align: center;
        }
    }
}

.m-b-5 {
    margin-bottom: 5px;
}

.m-b-2 {
    margin-bottom: 2px;
}
</style>
