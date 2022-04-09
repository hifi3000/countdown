<template>
  <div v-if="!isFetching" class="pb25">
    <h1>Countdown</h1>
    <h2>Choose numbers</h2>
    <div class="numbers">
      <div
        v-for="number in choiceNumbers"
        :key="number"
        class="number-button"
        @click="addChoiceNumber(number)"
      >
        {{ number }}
      </div>
    </div>
    <h2>Choose target</h2>
    <div class="numbers">
      <div
        v-for="number in targetNumbers"
        :key="number"
        class="number-button"
        @click="addTargetNumber(number)"
      >
        {{ number }}
      </div>
    </div>
    <div v-if="gameOn" class="game-numbers">
      <div class="styling-h4">Target:</div>
      <div v-if="chosenTarget" class="numbers">
        <div class="number-button">{{ chosenTarget }}</div>
      </div>
      <div class="styling-h4">Numbers:</div>
      <div v-if="chosenNumbers.length" class="numbers wide">
        <div
          v-for="number in chosenNumbers"
          :key="number"
          class="number-button"
        >
          {{ number }}
        </div>
      </div>
    </div>
    <div class="action-buttons">
      <div @click="resetNumbers" class="action-button">Reset</div>
      <div
        @click="checkCalculations"
        class="action-button"
        :class="buttonEnabled ? ' enabled' : ' disabled'"
      >
        Check
      </div>
    </div>
    <div v-if="message">
      <div class="m10">
        {{ message }}
      </div>
      <div v-if="solutions.length > 0" class="action-buttons">
        <div @click="showSolutions" class="action-button">show solutions</div>
      </div>
    </div>
    <div v-if="isVisible" class="m10">
      <div v-for="solution in solutions" :key="solution">
        {{ solution }}
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
axios.defaults.withCredentials = "true";

export default {
  name: "App",
  data() {
    return {
      isFetching: true,
      numbers: "",
      message: null,
      isVisible: false,
      solutions: [],
      targetNumbers: [1, 2, 3, 4, 5, 6, 7, 8, 9, 0],
      choiceNumbers: [100, 75, 50, 25, 10, 9, 8, 7, 6, 5, 4, 3, 2, 1],
      chosenNumbers: [],
      chosenTarget: "",
      buttonEnabled: false,
      gameOn: false,
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
    resetNumbers() {
      this.numbers = "";
      this.chosenTarget = "";
      this.chosenNumbers = [];
      this.buttonEnabled = false;
      this.isVisible = false;
      this.message = null;
      this.gameOn = false;
    },
    addChoiceNumber(number) {
      this.chosenNumbers.push(number);
      this.string2Numbers();
    },
    addTargetNumber(number) {
      this.chosenTarget += number;
      this.string2Numbers();
    },
    string2Numbers() {
      this.numbers = this.chosenTarget + " " + this.chosenNumbers.join(" ");
      this.buttonEnabled =
        this.chosenTarget.length == 3 && this.chosenNumbers.length == 6;
      this.gameOn =
        this.chosenTarget.length > 0 || this.chosenNumbers.length > 0;
    },
    async checkCalculations() {
      const accessdata = {
        numbers: this.numbers,
        withCredentials: true,
      };

      try {
        const res = await axios.post(
          "http://countdown.spacekit.de/api/",
          // "http://localhost/countdown/api/",
          accessdata,
          {
            headers: {
              "Content-type": "application/x-www-form-urlencoded",
            },
          }
        );

        if (res.status === 200) {
          this.message = res.data.message;
          this.solutions = res.data.solutions;
        } else {
          console.log(res);
        }
      } catch (e) {
        console.error(e);
      }
    },
    showSolutions() {
      this.isVisible = true;
    },
  },
};
</script>

<style>
.numbers {
  display: flex;
  justify-content: space-around;
  flex-wrap: wrap;
  width: 300px;
  margin: auto;
  padding-bottom: 10px;
}
.number-button {
  margin: 5px;
  padding: 5px 15px;
  background-color: #042791;
  border: 1px solid white;
  font-weight: 900;
  cursor: pointer;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}
.form-input {
  margin: 20px;
}
.action-buttons {
  display: flex;
  justify-content: space-around;
  flex-wrap: wrap;
  width: 300px;
  margin: 20px auto;
}
.action-button {
  background-color: #4998bd;
  color: black;
  cursor: pointer;
  padding: 5px 15px;
  border: 1px solid white;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}
.disabled {
  background-color: darkgrey;
  color: white;
  cursor: not-allowed;
}
.enabled {
  background-color: #042791;
  color: white;
}
.wide {
  width: 350px;
}
.styling-h4 {
  display: block;
  margin-block-start: 1em;
  margin-block-end: 1em;
  margin-inline-start: 0px;
  margin-inline-end: 0px;
  font-weight: bold;
}
.m10 {
  margin: 10px;
}
.pb25 {
  padding-bottom: 25px;
}
</style>
