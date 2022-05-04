<template>
  <div class="pos-r" >
    <div class="card background-black">
      <div class="cardcontent">
        <div class="cardcontentimg background-100">
          <img :src="cart.image" alt="" />
        </div>
        <div class="cardcontenttext">
          <h5 class="color-grean">{{ cart.name }}</h5>
          <p class="color-gray-f">
            {{ cart.description }}
          </p>
        </div>
      </div>
      <router-link v-if="open" :to="'/service/' + cart.id"
        ><button class="btn-indigo">Подробнее</button>
      </router-link>
    </div>
  </div>
</template>
<script>


export default {
  props: ["item", "open"],

  data() {
 return {
      cart: this.item,
    };
  },

};
</script>
<style lang="scss">
.pos-r {
  position: relative;
  display: flex;

  flex: 2 1 400px;
  @media (max-width: 960px) {
    flex: 2 1 300px;
  }
}
.card {
  &ImgEdit {
    top: 0;
    position: absolute;
    right: 0;
    z-index: 3;
    height: 50px;
    border-radius: 10px;

    cursor: pointer;
  }
  flex: 2 1 400px;
  @media (max-width: 960px) {
    flex: 2 1 300px;
  }
    max-width: 700px;
  position: relative;
  overflow: hidden;
  border-radius: 15px;
  box-shadow: 0 0 30px rgba(0, 0, 0, 0.5);
  display: flex;
  flex-direction: column;
  justify-content: space-between;

  a {
    width: 100%;
    padding: 0;
    button {

        margin: 20px;
    }
  }
  &content {
    &text {
      padding: 15px;
      background: rgba(255, 255, 255, 0.1);
      height: 100%;
      display: flex;
      flex-direction: column;
      p {
        font-size: 1em;
      }

    }
    &img {
      overflow: hidden;
      width: 100%;
      height: 200px;
      position: relative;

      img {
        width: 100%;
        height: 200px;
        position: absolute;
        object-fit: cover;
      }
    }
  }
}
</style>
