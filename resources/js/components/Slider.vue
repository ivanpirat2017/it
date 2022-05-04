<template>
  <div class="slider">
    <div class="slidernext">
      <img src="../../static/img/next.png" alt="" @click="next(+1)" />
      <img src="../../static/img/next.png" alt="" @click="next(-1)" />
    </div>
    <div class="sliderselecteds">
      <div
        class="sliderselectedsitem"
        @click="pushnext(i)"
        v-for="(item, i) in count"
        :key="item"
        :class="{ opacity: i != counter }"
      ></div>
    </div>
    <div
      class="sliderAll"
      :style="{
        width: 100 * count + '%',
        transform: 'translateX(-' + (100 / count) * counter + '%)',
        transition: `cubic-bezier(0.55, 0.055, 0.675, 0.19) ${timeslider}s`,
      }"
    >
      <div
        class="sliderAllitem"
        v-for="item in sliderItems"
        :key="item"
        :style="{
          width: 100 / count + '%',
        }"
      >
        <div class="sliderAllitemimg">
          <img :src="item.image" alt="" />
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { ServiceShow_ID, ServiceDestroy } from "../api-routes";
export default {
  data() {
    return {
      count: 6,
      counter: 0,
      slideriterval: null,
      sliderTimeBool: true,
      sliderItems: [],
      timeslider: 0,
    };
  },
  beforeUnmount() {
    clearInterval(this.slideriterval);
  },
  mounted() {
    this.axios.get(ServiceShow_ID + 3).then((r) => {
      this.sliderItems = r.data.data;
      this.count = this.sliderItems.length;
      setTimeout(() => {
        this.timeslider = 0.45;
      }, 0.3);
    });

    this.slideriterval = setInterval(() => {
      this.next(+1);
    }, 5000);
  },
  methods: {
   
    pushnext(item) {
      this.counter = item;
      clearInterval(this.slideriterval);
      this.slideriterval = setInterval(() => {
        this.next(+1);
      }, 5000);
    },
    next(item) {
      if (this.sliderTimeBool) {
        this.sliderTimeBool = false;
        this.counter = this.counter + item;
        if (this.counter < 0) {
          this.counter = this.count - 1;
        } else if (this.counter >= this.count) {
          this.counter = 0;
        }
        clearInterval(this.slideriterval);
        this.slideriterval = setInterval(() => {
          this.next(+1);
        }, 5000);
        setTimeout(() => {
          this.sliderTimeBool = true;
        }, 700);
      }
    },
  },
};
</script>
<style lang="scss">
.opacity {
  opacity: 0.2;
}
.slider {
  $stn: 1.9;
  max-width: 70vw;
  height: 70vw / $stn;
  background: rgba(255, 255, 255, 0.1);
  border-radius:5px;
  overflow: hidden;
  position: relative;
  z-index: 0;

  @media (max-width: 1200px) {
    max-width: 90vw;
    height: 100vw / $stn;
  }

  @media (max-width: 800px) {
    max-width: 94vw;
    height: 110vw / $stn;
  }

  @media (max-width: 500px) {
    max-width: 98vw;
    height: 110vw / $stn;
  }

  &selecteds {
    display: flex;
    position: absolute;
    transform: translateX(-50%) translateY(-50%);
    left: 50%;
    top: 90%;
    z-index: 2;
    &item {
      height: 10px;
      width: 50px;
      cursor: pointer;
      margin: 5px;
      transition: cubic-bezier(0.55, 0.055, 0.675, 0.19) 0.45s;
      background: rgba(255, 255, 255, 0.904);
      filter: invert(0.5);
      border-radius: 2px;
      @media (max-width: 800px) {
        margin: 3px;
        height: 7px;
        width: 35px;
      }
      @media (max-width: 380px) {
        margin: 2px;
        height: 4px;
        width: 20px;
      }
    }
  }
  &next {
    position: absolute;
    width: 100%;
    height: 100%;

    img {
      position: absolute;
      filter: invert(100%);
      opacity: 0.4;
      transform: translateX(-50%);
      cursor: pointer;
      top: 50%;
      z-index: 2;
      height: 125px;
      @media (max-width: 800px) {
        height: 70px;
      }
      @media (max-width: 380px) {
        height: 50px;
      }
      &:nth-child(1) {
        right: 0;
        transform: translateY(-50%);
      }
      &:nth-child(2) {
        left: 0;
        transform: rotate(180deg) translateY(50%);
      }
    }
  }
  &All {
    height: 100%;
    width: 100%;
    position: absolute;
    z-index: 0;
    display: flex;
    &item {
      display: flex;
      justify-content: center;
      align-items: center;
      text-align: center;
      height: 100%;

      &img {
        width: 100%;
        height: 100%;
        position: relative;
        button {
          position: absolute;
          top: 20px;
          right: 20px;
        }
        img {
          width: 100%;
          height: 100%;
          object-fit: cover;
        }
      }
    }
  }
}
</style>
