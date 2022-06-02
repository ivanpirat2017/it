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
        <div class="cnt">
            <h2 class="mt-40">Отзывы о
                <span> <span class="color-indigo"> I</span>T </span>

                <span class="color-red">Ц</span>ентре
            </h2>
            <div class="ServiceCommentitems">
                <div class="ServiceCommentitemsitem background-black" v-for="comment in comments" :key="comment.id">
                    <div class="ServiceCommentitemsitemName">
                        <p class="color-grean">
                            {{ comment.name }}
                        </p>
                    </div>
                    <div class="ServiceCommentitemsitemText">
                        <p class="color-gray-f">{{ comment.text }}</p>
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

import { ServiceShow_ID } from "../../api-routes";
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
            comments: [
                { name: 'Баринова Изабелла', text: 'Очень довольны услугами провайдера. И наименьшее, что я могу сделать в благодарность это оставить положительный отзыв.' },
                { name: 'Бруевича Ярослава', text: 'Очень крутая компания! Пользуемся арендованным сервером, все стабильно! Поддержка суперская, молниеносная, спасибо большое ребятам за такой сервис и высшую культуру обслуживания клиентов! Так держать! Всем советуем)' },
                { name: 'Кудрявцев Венедикт', text: 'Все понравилось. И персонал, и месторождение, и печеньки с кофе, и чистота в помещениях.' },
                { name: 'Ювелева Марьяна', text: 'Это, пожалуй лучшее место в моем трудовом стаже) Если вам посчастливилось попасть в команду Название, вы сами все поймете. Прекрасное отношение отдела кадров полное сопровождение и адаптация в первые дни работы. Кофе чай, печеньки газировка, вкусные обеды. Никаких проблем с оплатой, все прозрачно и понятно' },
                { name: 'Калганов Никита', text: 'Хочу поблагодарить Константина, работа выполнена по договоренности, качественно + не дорого, понравилось' },
                { name: 'Аксёнова Милана', text: 'В общении было всё просто и открыто. На сложную задачу было предложено рациональное решение . Работа была выполнена быстро и качественно. Спасибо.' },
                { name: 'Радостин Валерий', text: 'Всё по существу. Всегда на связи. Приехала, проконсультировалась, посмотрела заказ и купила. В тот же день опробовала. Всё в порядке. Благодарю :)' },
            ]
        };
    },
    mounted() {
        this.getServiceShow1();
        this.getServiceShow2();
    },
    methods: {
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

    &Fon {}

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


