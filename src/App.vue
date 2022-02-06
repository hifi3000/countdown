<template>
  <router-view v-slot="slotProps">
    <transition name="route" mode="out-in">
      <component :is="slotProps.Component"></component>
    </transition>
  </router-view>
</template>

<style>
* {
  /* color: #f5f5f5; */
  /* color: #e6e6e6; */
  color: #e6e6e6;
  /* background-color: #141414; */
  /* background-color: #1a1a1a; */
  background-color: #1a1a1a;
}

#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
}
</style>
