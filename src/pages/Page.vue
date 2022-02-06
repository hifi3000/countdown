<template>
  <div v-if="!isFetching">
    <h1>Das Klaus</h1>
    <div class="block">
      <h2>ToDos</h2>
      <div>Übersicht Vocal-Recordings</div>
    </div>
    <div class="block">
      <h2>Stats</h2>
      <h3>Instagram</h3>
      <div>599</div>
      <h3>SoundCloud</h3>
      <div>1200</div>
      <h3>Twitter</h3>
      <div>799</div>
    </div>
    <div class="block">
      <h2>Leads</h2>
      <div>Katja Epstein</div>
    </div>
    <div class="block">
      <h2>Dates</h2>
      <div>Frühling</div>
    </div>
  </div>
</template>

<script>
export default {
  name: "App",
  data() {
    return {
      isFetching: true,
    };
  },
  created() {
    this.checklogin();
  },
  methods: {
    checklogin() {
      const specific_date = Date.now();
      const current_date = localStorage.getItem("sha1");
      if (current_date > specific_date) {
        this.isFetching = false;
      } else {
        window.location.href = "/login";
      }
    },
  },
};
</script>
