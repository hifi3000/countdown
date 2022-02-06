<template>
  <div id="login" OnLoad="document.loginform.email.focus();">
    <img class="login_favicon" src="../assets/logo.png" />
    <h4>{{ msg }}</h4>
    <form
      v-on:submit.prevent="onSubmit"
      action="/"
      method="post"
      name="loginform"
    >
      E-Mail:<br />
      <input type="email" size="40" maxlength="250" name="email" />
      <br />Dein Passwort:<br />
      <input type="password" size="40" maxlength="250" name="password" /><br />
      <input type="submit" value="Abschicken" />
    </form>
  </div>
</template>

<script>
import axios from "axios";
axios.defaults.withCredentials = "true";

export default {
  name: "Login",
  data() {
    return {
      msg: "Bitte zuerst einloggen",
    };
  },
  methods: {
    onSubmit(submitEvent) {
      const email = submitEvent.target.elements.email.value;
      const password = submitEvent.target.elements.password.value;
      this.login(email, password);
    },
    async login(email, password) {
      const accessdata = {
        passwort: password,
        email: email,
        withCredentials: true,
      };

      try {
        const res = await axios.post(
          "http://localhost/countdown/api/?logins",
          accessdata,
          {
            headers: {
              "Content-type": "application/x-www-form-urlencoded",
            },
          }
        );

        if (res.status === 200) {
          localStorage.setItem("sha1", Date.now() + 1000 * 60 * 60 * 24 * 28);
          window.location.href = "/";
        } else {
          this.msg = "wrong user or password";
        }
      } catch (e) {
        this.msg = "wrong user or password";
        console.error(e);
      }
    },
  },
};
</script>

<style scoped>
#login {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  color: #373737;
  margin: auto;
  max-width: unset;
  height: 100vh;
}

#login input[type="submit"] {
  display: flex;
  justify-content: center;
  align-items: center;
  background-color: hsl(220 20% 22% / 1);
  border: none;
  color: #cccccc;
  text-decoration: none;
  margin: 20px auto;
  padding: 10px 50px;
  cursor: pointer;
  border-radius: 10px;
  width: auto;
  height: auto;
  text-transform: none;
}

#login input[type="email"],
input[type="password"] {
  padding: 6px 10px;
  margin: 4px 0 8px 0;
  border: 1px solid #ccc;
  border-radius: 4px;
}

#login input:focus {
  outline: none;
  border: 1px solid white;
  box-shadow: 0 0 4px 1px white;
}

.login_favicon {
  height: 50px;
}
</style>
