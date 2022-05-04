<template>
  <div class="cnt p-t About">
    <h2 >О компании</h2>
    <p class="color-gray-f">
      Компания ООО "IT Центр" работает на Курском IT-рынке. У
      наших специалистов есть знания подтвержденные сертификатами и многолетней
      практикой. Есть партнёрские отношения с крупными ИТ-поставщикам, с
      некоторыми заключены договора на эксклюзивных условиях. Накоплен
      внушительный практический опыт разработки проектов, их инсталляций и
      внедрений. Мы стремимся сохранить хорошие отношения с нашими существующими
      клиентами и ищем взаимовыгодных плоскостей сотрудничества с новыми
      компаниями.
    </p>
    <h2   class=" color-indigo p-t-20">Сертификаты</h2>
    <div class="AboutCertificate">
      <img src="../../../static/img/certificate/1.jpg" alt="" />
      <img src="../../../static/img/certificate/2.jpg" alt="" />
    </div>
  </div>
</template>
<script>
export default {};
</script>
<style lang="scss">
.About {
  &Certificate {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    img{
        display: flex;
        flex: 1 1 300px;
        max-width: 100%;
        border-radius: 10px;
    }
  }
}
</style>
