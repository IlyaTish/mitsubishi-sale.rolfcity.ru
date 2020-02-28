import { CK_HASH, BACK_URL, RESERVE_COOKIES } from "./send-constants";
import CONSTANTS from "./constants";
import axios from "axios";

export default function(event, data, cKeeper, manager_phone) {
  let tocall = event.phone.match(/\d+/g).join(""),
    source = event.data || data,
    path =
      source.form +
      (source.model ? "," + source.model : "") +
      (source.comp ? "," + source.comp : ""),
    type = source.type,
    referrer = document.referrer,
    ga =
      window.ga &&
      window.ga.getAll &&
      window.ga.getAll()[0] &&
      window.ga.getAll()[0].get("clientId"),
    totype = [
      {
        id: 1,
        key: "sale"
      },
      {
        id: 2,
        key: "credit"
      },
      {
        id: 3,
        key: "service"
      }
    ].find(item => {
      return item.key === type;
    });

  let send_data = {
    type: totype.id || 1,
    phone: tocall,
    url: window.location.href,
    path: path,
    debug: isDebug(tocall),
    ga_client_id: ga,
    referrer: referrer
  };

  if (cKeeper === "actioncall") {
    send_data.ck_hash = getCkHash();
    send_data.is_local = isLocal();
    send_data.ck_log = {
      status: 1,
      messages: []
    };
    send_data.ck_log.message = send_data.ck_log.messages.join("\n");
    send_data.ck_log.messages = undefined;
  }

  if (manager_phone) send_data.manager_phone = manager_phone;

  if (send_data.phone.toString().length > 10) {
    if (cKeeper === "actioncall") {
      if (!send_data.debug) {
        return fetchCk(send_data);
      }
    } else if (cKeeper === "ctw") {
      CTWRequest(tocall);
    } else if (typeof CBHCore !== "undefined" && cKeeper === "CBH") {
      CBHCore.api.sendCall({ phone: "+" + tocall });
    }
  }

  return axios.post("/overall/back/send", { ...send_data });
}

function isLocal() {
  /*
   * Данная строка нам была послана самим колкипером!
   * */
  return (
    typeof CallKeeper === "undefined" ||
    typeof CallKeeper.f === "undefined" ||
    typeof CallKeeper.f.justCookies !== "function"
  );
}

function handleCkError(send_data) {
  if (send_data.is_local) {
    return fetchSend(send_data);
  } else {
    send_data.is_local = true;
    return fetchCk(send_data);
  }
}

function getCkHash() {
  let ck_hash = CK_HASH;
  if (!isLocal()) {
    ck_hash = CallKeeper.p.hash;
  }
  return ck_hash;
}

function fetchCk(send_data) {
  const cookiesBasket = getCookiesBasket(send_data.is_local);
  let data_form = getFormData(send_data.phone, cookiesBasket);

  let url =
    "https://api.callkeeper.ru/formReceiver?isSend" +
    "&widgetHash=" +
    send_data.ck_hash +
    "&phone=" +
    encodeURIComponent(send_data.phone) +
    "&cookiesBasket=" +
    cookiesBasket +
    "&backUrl=" +
    encodeURIComponent(BACK_URL) +
    "&responseMethod=GET";

  return axios
    .get(url, { params: { ...data_form } })
    .then(res => {
      if (res.status === 200) {
        send_data.ck_log.messages = send_data.ck_log.messages
          .concat(["Отправка в callkeeper была успешна"])
          .concat(getStandardMessages(send_data.is_local, url, cookiesBasket));
        return fetchSend(send_data);
      } else {
        send_data.ck_log.messages = send_data.ck_log.messages
          .concat([
            "Попытка отправить провалилась",
            "Статус ошибки: " + res.status + ": " + res.statusText
          ])
          .concat(getStandardMessages(send_data.is_local, url, cookiesBasket));
        send_data.ck_log.status = 0;
        return handleCkError(send_data);
      }
    })
    .catch(error => {
      send_data.ck_log.messages = send_data.ck_log.messages
        .concat([
          "Попытка отправить провалилась",
          "Сообщение ошибки: " + error.message
        ])
        .concat(getStandardMessages(send_data.is_local, url, cookiesBasket));
      send_data.ck_log.status = 0;
      return handleCkError(send_data);
    });
}

function getStandardMessages(is_local, url, cookiesBasket) {
  return [
    "Использовался резервный метод: " + (is_local ? "да" : "нет"),
    "url: " + url,
    "cookiesBasket: " + decodeURIComponent(cookiesBasket),
    "userAgent: " + navigator.userAgent
  ];
}

function getFormData(phone, cookiesBasket) {
  let ret = new FormData();
  ret.append("tel", phone);
  ret.append("cookiesBasket", decodeURIComponent(cookiesBasket));
  return ret;
}

function getCookiesBasket(force_local) {
  if (!force_local && !isLocal()) {
    return CallKeeper.f.justCookies();
  } else {
    return encodeURIComponent(RESERVE_COOKIES);
  }
}

function isDebug(phone) {
  const debugs = ["71111111111", "79999999999"];
  if (debugs.some(dphone => dphone === phone)) {
    return 1;
  }
  return 0;
}

function CTWRequest(phone) {
  if (window.ctw) {
    window.ctw.createRequest("lpvwspbru", phone, function(success, data) {
      console.log(success, data);
      if (success) {
        console.log(
          "Создана заявка на колбек, идентификатор: " + data.callbackRequestId
        );
      } else {
        switch (data.type) {
          case "request_throttle_timeout":
          case "request_throttle_count":
            console.log("Достигнут лимит создания заявок, попробуйте позже");
            break;
          case "request_phone_blacklisted":
            console.log("номер телефона находится в черном списке");
            break;
          case "validation_error":
            console.log("были переданы некорректные данные");
            break;
          default:
            console.log(
              "Во время выполнения запроса произошла ошибка: " + data.type
            );
        }
      }
    });
  }
}