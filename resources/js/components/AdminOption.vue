<template>
    <div class="AdminOption border-indigo">
        <div class="AdminOptionText">
            <div class="">
                <input type="checkbox" name="" id=" " v-model="delivery">
                <img src="../../static/img/delivery.png" alt="">
            </div>
            <input type="text" v-model="title" class="color-white" placeholder="название" />
            <input type="number" v-model="price" class="color-white" placeholder="цена" />
        </div>
        <div class="AdminOptionCircl background-indigo">
            <h4 class="m-b-2" @click="create()">создать</h4>
        </div>
    </div>
</template>
<script>
import { ServiceOptionCreate } from "../api-routes";
export default {
    props: ["idService", "getOptions"],
    data() {
        return {
            title: "",
            price: 0,
            delivery: false
        };
    },
    methods: {
        create() {
            const Form = new FormData();
            Form.append("price", this.price);
            Form.append("title", this.title);
            Form.append("id_service", this.idService);
            Form.append("delivery", this.delivery);

            this.axios({
                method: "post",
                headers: {
                    Authorization: "Bearer " + localStorage.getItem("token"),
                },
                url: ServiceOptionCreate,
                data: Form,
            })
                .then((r) => {
                    this.getOptions();
                    this.price = 0
                    this.title = ''
                    this.delivery = false
                })
                .catch((r) => { });
        },
    },
};
</script>
<style lang="scss">
.AdminOption {
    transition: 0.5s;
    flex: 1 1 100%;
    background: rgba(255, 255, 255, 0.1);
    justify-content: space-between;
    align-items: center;
    padding: 5px;
    border-radius: 10px;

    display: flex;

    &Text {
        display: flex;
        justify-content: space-between;
        flex: 1 1;
        gap: 10px;

        div {
            display: flex;
            align-items: center;
            gap: 5px;

            input {
                height: 20px;
                width: 20px;
            }

            img {
                height: 25px;
            }
        }

        h5 {
            font-size: 1em;
        }

        input {
            &:nth-child(3) {
                width: 100px;

                @media (max-width: 500px) {
                    width: 60px;
                }
            }
        }
    }

    &Circl {
        padding: 5px;
        margin: 0 0 0 25px;
        display: flex;
        border-radius: 10px;
        align-items: center;
        flex-shrink: 0;
        justify-content: center;
        cursor: pointer;
        text-align: center;

        h4 {
            padding: 0;
            font-size: 1.2em;
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
