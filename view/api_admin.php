<h1 class="page_title">API 관리자</h1>

<div class="content">

  <div class="admin_section">
    <div class="wrap">
      <div class="title">
        <h1>관리자</h1>
        <div class="line"></div>
        <p>API를 관리해보세요.</p>
      </div>

      <div class="admin col-flex">
        <div class="btn" onclick="Modal.open('admin')">추가</div>

        <table>
          <thead>
            <tr>
              <th>아이디</th>
              <th>api키</th>
              <th>테이블</th>
              <th>name</th>
              <th>info</th>
              <th>addr</th>
              <th>phone</th>
              <th>time</th>
              <th>score</th>
            </tr>
          </thead>
          <tbody>

          </tbody>
        </table>
      </div>
    </div>
  </div>

</div>

<template>

  <div class="admin_modal">
    <div class="main">
      <div class="top flex jcc aic">
        <h3>권한 관리</h3>
      </div>

      <div class="inputs">
        <div class="btn_box">
          <div class="input_box">
            <label for="userid">아이디</label>
            <input type="text" name="userid" id="userid" oninput="changeUser()">
          </div>

          <div class="input_box">
            <label for="table">테이블</label>
            <select name="table" id="table" onchange="checkUser()">
              <option value="" hidden selected>선택해주세요.</option>
              <option value="place">place</option>
              <option value="food">food</option>
            </select>
          </div>
        </div>

        <table>
          <thead>
            <tr>
              <th>name</th>
              <th>info</th>
              <th>addr</th>
              <th>phone</th>
              <th>time</th>
              <th>score</th>
            </tr>
          </thead>
          <tbody class="permission">
          </tbody>
        </table>
      </div>
    </div>
    <div class="btn_box full">
      <div class="btn" onclick="Modal.close()">닫기</div>
    </div>
  </div>

</template>

<script>

  $(document)
    .on("change", ".permission input", clickCheckbox);

  function checkUser(){
    const userid = $("#userid").val()
    const table = $("#table").val()

    $.getJSON(`/permission/${userid}/${table}`)
      .then(res => {
        if(!res.user) {
          changeUser();
          return alert("없는 유저입니다.")
        };
        const list = res.permission;

        $(".modal .permission").html(`
          <tr>
            <td>
              <input 
                type="checkbox" 
                name="permi" 
                id="name" 
                ${ !list.includes("name") ? "checked" : "" }
              >
            </td>
            <td>
              <input 
                type="checkbox" 
                name="permi" 
                id="info" 
                ${ !list.includes("info") ? "checked" : "" }
              >
            </td>
            <td>
              <input 
                type="checkbox" 
                name="permi" 
                id="addr" 
                ${ !list.includes("addr") ? "checked" : "" }
              >
            </td>
            <td>
              <input 
                type="checkbox" 
                name="permi" 
                id="phone" 
                ${ !list.includes("phone") ? "checked" : "" }
              >
            </td>
            <td>
              <input 
                type="checkbox" 
                name="permi" 
                id="time" 
                ${ !list.includes("time") ? "checked" : "" }
              >
            </td>
            <td>
              <input 
                type="checkbox" 
                name="permi" 
                id="score" 
                ${ !list.includes("score") ? "checked" : "" }
              >
            </td>
          </tr>
        `)
      })
  }

  function changeUser(){
    $("#table").val("");
    $(".modal .permission").html("")
  }

  function clickCheckbox(e){
    const userid = $("#userid").val()
    const table = $("#table").val()
    const list = $(".permission input:not(:checked)").toArray().map(v => $(v).attr("id"));

    $.post(`/permission/${userid}/${table}`, { list });
  }

  function loadData(){
    $.getJSON("/permission_list")
      .then(res => {
        $(".admin table tbody").html(res.map(v => {
          const list = JSON.parse(v.list);

          return `
            <tr onclick="openPermission('${v.userid}', '${v.target_table}')">
              <td>${v.userid}</td>
              <td>${v.api_key}</td>
              <td>${v.target_table}</td>
              <td>${!list.includes("name") ? "수락" : "거절"}</td>
              <td>${!list.includes("info") ? "수락" : "거절"}</td>
              <td>${!list.includes("addr") ? "수락" : "거절"}</td>
              <td>${!list.includes("phone") ? "수락" : "거절"}</td>
              <td>${!list.includes("time") ? "수락" : "거절"}</td>
              <td>${!list.includes("score") ? "수락" : "거절"}</td>
            </tr>
          `
        }))
      })
  }

  function openPermission(userid, table){
    Modal.open("admin");

    $(".modal #userid").val(userid);
    $(".modal #table").val(table);

    checkUser();
  }

  loadData();
  setInterval(loadData, 500);

</script>