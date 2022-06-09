<template>
    <Loader v-if="loader" />
    <div class="p-t Home">
        <HomeStart />
        <div class="cnt">
            <Slider class="Homeslider" />
            <div class="p-rel" v-if="$root.role == 'admin'">
            </div>
            <h5 class="color-gray-f">Ваш провайдер в сфере цифровых технологий</h5>
            <p class="color-gray-f">
                Сеть магазинов компьютерной и сопутствующей техники, оборудования для
                теле-радио приема, видеонаблюдения. Ремонт.
            </p>
        </div>
        <div class="cnt p-b-30">
            <h2 class="mt-40 fddgf">Наши услуги</h2>
            <div class="Homeactoins">
                <Card v-for="item in OurServices" :item="item" :open="true" :key="item.id" />
                <div class="p-rel" v-if="$root.role == 'admin'">

                </div>
            </div>
        </div>
        <div class="HomeContent1">
            <img class="HomeContent1img" src="../../../static/img/fon-tekstura-siniy.jpg" alt="" />
            <div class="cnt">
                <div class="Homeactoins">
                    <h2 class="">
                        ПОЧЕМУ ВЫБИРАЮТ <span class="color-indigo">I</span>T-<span class="color-red">Ц</span>ентр
                    </h2>

                    <Card v-for="item in WhyChoose" :item="item" :key="item.id" />
                    <div class="p-rel" v-if="$root.role == 'admin'">
                    </div>
                </div>
            </div>
        </div>
        <div class="cnt">
            <h2 class="mt-40">Расположение магазинов</h2>
            <iframe src="https://www.google.com/maps/d/embed?mid=1ym8UAD1kR2wwXae9z2WiGZqvpKG6bHBp&ehbc=2E312F"
                width="100%" height="700px"></iframe>
        </div>
        <div class="cnt mt-40">
            <h2 class="">Отзывы о
                <span> <span class="color-indigo"> I</span>T </span>

                <span class="color-red">Ц</span>ентре
            </h2>

            <div class="infocount background-red" v-if="boolcommentlength">
                <h5>
                    Введите больше 10 символов для написания комментария.
                </h5>

            </div>

            <div v-if="$root.role != ''" class="ServiceComment background-black">
                <h5>Написать отзыв</h5>
                <div class="ServiceCommentWrite">
                    <p id="textmeggage" class="background-100" :class="{ 'border-indigo': focusWriteComment }"
                        @mousemove="focusWriteComment = true" @mouseleave="focusWriteComment = false" contenteditable>
                    </p>
                    <button class="background-gray-blue" @click="createComment()">
                        отправить
                    </button>
                </div>


            </div>
            <div class="ServiceCommentitems" style="margin: 20px 0;">

                <div class="ServiceCommentitemsitem background-black" v-for="comment in comments" :key="comment.id">
                    <div class="ServiceCommentitemsitemName">
                        <p class="color-grean">
                            {{ comment.user.surname }} {{ comment.user.name }}
                        </p>
                    </div>
                    <div class="ServiceCommentitemsitemText">
                        <p class="color-gray-f">{{ comment.text_comment }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Slider from "../../components/Slider.vue";
import AdminEditCart from "../../components/AdminEditCart.vue";
import Loader from "../../components/Loader.vue";
import HomeStart from "../../components/HomeStart.vue";
import Card from "../../components/Card.vue";

import {
    ServiceShow_ID, CommentCreate,
    CommentShow_ID,
} from "../../api-routes";
export default {
    components: {
        Slider,
        Card,
        AdminEditCart,
        Loader,
        HomeStart,
    },
    data() {
        return {
            OurServices: [],
            WhyChoose: [],
            openEdit1: false,
            openEdit2: false,
            openEdit3: false,
            loader: true,
            boolcommentlength: false,
            focusWriteComment: false,
            comments: []
        };
    },
    mounted() {
        this.getServiceShow1();
        this.getServiceShow2();
        this.axios.get(CommentShow_ID).then((r) => {
            console.log(r);
            this.comments = r.data.data;
        });
    },
    methods: {
        createComment() {
            const Form = new FormData();
            const text = document.querySelector("#textmeggage");
            if (text.textContent.length < 10) {
                this.boolcommentlength = true
                setTimeout(() => {
                    this.boolcommentlength = false
                }, 5000);
                return 0;
            }
            Form.append("text_comment", text.textContent);
            Form.append("id_service", this.$route.params.id);

            this.axios({
                method: "post",
                headers: {
                    Accept: "multipart/form-data",
                    Authorization: "Bearer " + localStorage.getItem("token"),
                },
                url: CommentCreate,
                data: Form,
            })
                .then((r) => {
                    text.textContent = "";
                    this.boolcommentlength = false
                })
                .catch((r) => { });
        },
        getServiceShow1() {
            this.axios
                .get(ServiceShow_ID + 1)
                .then((r) => {
                    this.OurServices = r.data.data;
                })
                .catch((r) => this.getServiceShow1());
        },
        getServiceShow2() {
            this.axios
                .get(ServiceShow_ID + 2)
                .then((r) => {
                    this.WhyChoose = r.data.data;
                    this.loader = false;
                })
                .catch((r) => this.getServiceShow2());
        },
        cartUpdate() {
            this.axios.get(ServiceShow_ID + 1).then((r) => {
                this.OurServices = r.data.data;
            });
            this.axios.get(ServiceShow_ID + 2).then((r) => {
                this.WhyChoose = r.data.data;
            });
        },
        openEditclick1() {
            this.openEdit1 = !this.openEdit1;
        },
        openEditclick2() {
            this.openEdit2 = !this.openEdit2;
        },
        openEditclick3() {
            this.openEdit3 = !this.openEdit3;
        },
    },
};
</script>
<style lang="scss">
.p-rel {
    position: relative;
}

.Home {
    &slider {
        margin: 20px 0;
    }
    &Content1 {
        z-index: 1;
        padding: 50px 0;
        overflow: hidden;
        position: relative;
        &img {
            top: 0;
            z-index: -1;
            left: 0;
            position: absolute;
            width: 100%;
            object-fit: cover;
            height: 100%;
        }
    }

    &actoins {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        gap: 2rem;

        h2 {
            color: white;
        }
    }
}
</style>


