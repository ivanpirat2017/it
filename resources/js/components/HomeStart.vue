<template   >
  <div class="HomeStartback">
    <div class="HomeStartCntCircl background-indigo"></div>
    <div class="cnt HomeStart">
      <div class="HomeStartlogo">
        <h1 class="">
          <span> <span class="color-indigo">I</span>T</span>
          <div class="HomeStartlogoBox"></div>
        </h1>
        <h1><span class="color-red">Ц</span>ентр</h1>
        <button class="background-indigo" @click="scrollcnt()">Услуги</button>
      </div>
      <div class="HomeStartCnt">
        <div class="HomeStartCntText">
          <h4>
            Ваш провайдер
            <div class="HomeStartlogoBox"></div>
          </h4>
          <h4>в сфере цифровых технологий</h4>
        </div>
        <div class="HomeStartCntSlogans">
          <div>
            <span class="">1</span>
            <h5>Нет времени? Сделаем за вас!</h5>
          </div>
          <div>
            <span class="">2</span>
            <h5>Изобретательные альтернативные решения.</h5>
          </div>
          <div>
            <span class="">3</span>
            <h5>Клиенты на первом месте.</h5>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  methods: {
    scrollcnt() {
      document.querySelector(".fddgf").scrollIntoView({
        behavior: "smooth",
        block: "start",
      });
    },
  },
};
</script>
<style lang="scss">
.HomeStart {
  height: calc(100vh - 84px);

  display: flex;
  align-items: center;
  justify-content: space-between;
  @media (max-width: 1000px) {
    flex-direction: column;
    height: 100vh;
    justify-content: space-around;
  }

  &back {
    overflow: hidden;
    position: relative;
    background: rgba(0, 0, 0, 0.1);
  }
  &logo {
    display: flex;
    flex-direction: column;

    h1 {
      display: flex;
      align-items: center;

      justify-content: space-between;
    }
    &Box {
      margin-right: 30px;
      width: 50px;
      height: 50px;
      background: #ffa632;
      border-radius: 100%;
      flex: 0 0 50px;
    }
  }
  &Cnt {
    display: flex;
    justify-content: flex-end;
    flex-direction: column;
    &Slogans {
      padding-top: 50px;
      display: flex;
      flex-direction: column;
      @media (max-width: 1000px) {
        padding-top: 10px;
      }
      div {
        display: flex;
        align-items: flex-end;
        gap: 10px;
        span {
          font-size: 2.5em;
          font-family: "Montserrat", sans-serif;
          font-weight: 900;
          color: white;
          width: 20px;
        }
        h5 {
          font-size: 1.5rem;
          color: white;
          @media (max-width: 1000px) {
            font-size: 1rem;
          }
        }
      }
    }
    &Text {
      width: 100%;
      z-index: 4;

      h4 {
        color: white;
        display: flex;
        align-items: center;
        gap: 20px;
      }
    }
    &Circl {
      position: absolute;
      border-radius: 100%;
      left: 30vw;
      top: -50vh;
      width: 200vh;
      height: 200vh;
      z-index: -2;
      @media (max-width: 1000px) {
        width: 200vh;
        height: 200vh;
        transform: translateX(-50%);
        left: 50vw;
        top: 40vh;
      }
    }
  }
}
</style>


