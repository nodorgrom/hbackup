window.addEventListener('load', () => {

  class Handler {
    constructor() {
      if (document.querySelectorAll('.table-handler')[0]) {
        this.hostHandler = document.querySelectorAll('.table-handler')[0];
        this.hostHandlerLength = this.hostHandler.children[0].children.length;
        this.buttons = this.hostHandler.children[0].children;
      }
    }

    getHandlers(item) {
      this.counter = 0;

      for( ; this.counter < this.hostHandlerLength; this.counter++) {
        this.buttons[this.counter].addEventListener('click', (e) => {


          var node_name = e.target.getAttribute('name');
          var node_value = e.target.getAttribute('value');
          this.node = e.target;
          var node = this.node;

          switch(this.getNeedHandler( node_name )) {
            case 'node_backup':
              console.log( this.node );
              this.node.setAttribute('disabled', 'disabled');
              confirmation.createForm( node_name, node_value, function(node) {
                host.getBackup( host.node );
              });
            break;
            case 'node_on':
              confirmation.createForm( node_name, node_value, function(node) {
                host.turnOn( host.node, host.node.nextElementSibling );
              });
            break;
            case 'node_off':
              confirmation.createForm( node_name, node_value, function(node) {
                host.turnOff( host.node, host.node.previousElementSibling );
              });
            break;
            case 'node_delete':
              confirmation.createForm( node_name, node_value, function(node) {
                host.delete(host.node);
              });

              
            break;
            default:
              console.log( 'this is default rule' );
            break;
          } 
          // console.log( e.target );
        });
      }

    }

    getNeedHandler(item) {
      for( var i = 0; i < this.hostHandlerLength; i++) {
        if (this.buttons[i].getAttribute('name') == item) {
          return this.buttons[i].getAttribute('name');
        }
      }
    }

    getBackup(node) {
      // console.log( node.getAttribute('name') );
      var prop = 'backup';
      var val = '=1';
      var node_prop = '&node_id';
      var node_id = '=' + document.URL.split("/").join(',').split(",")[4];
      this.ajaxPost(prop, val, node_prop + node_id);
    }

    turnOn(node, target) {
      // console.log( node.getAttribute('name') );
      var prop = 'active';
      var val = '=1';
      var node_prop = '&node_id';
      var node_id = '=' + document.URL.split("/").join(',').split(",")[4];
      this.toggle(node, target);
      this.switch(prop);
      // console.log( prop, val, node_prop + node_id );
      this.ajaxPost(prop, val, node_prop + node_id);
    }

    turnOff(node, target) {
      // console.log( node.getAttribute('name') );
      var prop = 'inactive';
      var val = '=0';
      var node_prop = '&node_id';
      var node_id = '=' + document.URL.split("/").join(',').split(",")[4];
      this.toggle(node, target);
      this.switch(prop);
      // console.log( prop, val, node_prop + node_id );
      this.ajaxPost(prop, val, node_prop + node_id);
    }

    delete(node) {
      // console.log( node.getAttribute('name') );
      var prop = 'delete';
      var val = '=1';
      var node_prop = '&node_id';
      var node_id = '=' + document.URL.split("/").join(',').split(",")[4];
      this.ajaxPost(prop, val, node_prop + node_id);
    }

    ajaxPost(prop, val, node_id) {
      // console.log( node_id );
      var node_id = node_id;
      var request = new XMLHttpRequest();

      request.onreadystatechange = function() {
        var result = document.querySelector('.result');
        if(prop == 'delete') {
          location.replace('https://b000313/hosts');
        }

        
        
        // if(request.readyState == 4 && request.status == 200) {      
        //   result.innerHTML = request.responseText;

        //   var rootPassHandler = result.querySelector('[name=root_pass_submit]');
        //   var rootPass = result.querySelector('[name=root_pass_value]');

        //   var nodeResult = document.querySelector( '[name=node_backup]' );
        //   nodeResult.removeAttribute('disabled');

        //   if (rootPassHandler != null) {
        //     rootPassHandler.addEventListener('click', function(e){
        //       e.preventDefault();
        //       var passValue = rootPass.value;

        //       var XHR = new XMLHttpRequest();

        //       XHR.onreadystatechange = function() {
        //         var result2 = document.querySelector('.result2');

        //         if (XHR.readyState == 4 && XHR.status == 200) {
        //           result2.innerHTML = XHR.responseText;
        //         }
        //       }
              
        //       XHR.open('POST', '../models/Exec.php');
        //       XHR.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        //       XHR.send('passValue=' + passValue + node_id);

        //     });
        //   }

        // }
      }

      request.open('POST', '../models/Exec.php');
      request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      request.send(prop + val + node_id);
    }


    toggle(node1, node2) {
      node1.setAttribute('disabled', 'disabled');
      node2.removeAttribute('disabled');
    }

    switch(prop) {
      if (prop == 'active' && prop != 'delete') {
        let dataToggle = document.querySelector('.node-deactivate');
        dataToggle.innerHTML = 'активен';
        dataToggle.classList.remove('node-deactivate');
        dataToggle.classList.add('node-active');
      } else {
        if (document.querySelector('.node-active')) {
          let dataToggle = document.querySelector('.node-active');
          dataToggle.innerHTML = 'неактивен';
          dataToggle.classList.remove('node-active');
          dataToggle.classList.add('node-deactivate');
        }
      }
    }



  }

  var host = new Handler();
  host.getHandlers();



  class Confirmation extends Handler {

    constructor() {
      super();
      this.counter = 0;
      this.paranja = document.querySelector('.paranja');
    }

    getElements() {
      this.paranja = document.querySelector('.paranja');
      return this.paranja;
    }

    activateParanja( node_name, node_value ) {

      for( ; this.counter < this.hostHandlerLength; this.counter++ ) {
        this.buttons[this.counter].addEventListener('click', (e) => {

          if(typeof(this.paranja == 'null') || typeof(this.paranja == 'undefined')) {
            var div = document.createElement('div');
            div.classList.add('paranja');
            document.body.appendChild(div);
            this.deactivateParanja(div);
          }
        });
        
      }

    }

    deactivateParanja(elem) {
      if (typeof(elem) != 'undefined') {
        elem.addEventListener('click', (e) => {
          this.getElements().remove();
          this.removeForm();
          var nodeResult = document.querySelector( '[name=node_backup]' );
          nodeResult.removeAttribute('disabled');
        });
      }
    }



    createForm(elem, elem_value, callback) {

      var modalWrapper = document.createElement('div');
      var modalWindow = document.createElement('div');
      var modalH2 = document.createElement('h2');
      var modalOk = document.createElement('button');
      var modalCancel = document.createElement('button');
      var endings_raw = [
        {node : 'node_backup', node_value : ' сервера'},
        {node : 'node_on', node_value : ' бэкап сервера'},
        {node : 'node_off', node_value : ' данный узел'},
        {node : 'node_delete', node_value : ' данный узел'},
      ];


      function getFullEndings(item) {
        var fullEndingsNode = [item.node, item.node_value];
        return fullEndingsNode;
      }


      modalWrapper.classList.add('modalWrapper');
      modalWindow.classList.add('modalWindow');
      modalH2.classList.add('modalH2');
      modalOk.classList.add('modalOk');
      modalCancel.classList.add('modalCancel');

      document.body.appendChild(modalWrapper);
      modalWrapper.appendChild(modalWindow);
      modalWindow.appendChild(modalH2);
      modalWindow.appendChild(modalOk);
      modalWindow.appendChild(modalCancel);

      modalH2.innerHTML = 'Вы уверены, что хотите ';
      var endings_sort = endings_raw.map(getFullEndings);

      for( let i = 0; i < endings_sort.length; i++ ) {
        if (endings_sort[i][0] == elem) {
          modalH2.innerHTML += elem_value + ' ' + endings_sort[i][1] + '?';
        }
      }


      modalOk.innerHTML = 'Да';
      modalCancel.innerHTML = 'Отмена';

      modalWindow.addEventListener('click', (e) => {
        if (e.target.getAttribute('class') == 'modalOk') {
          callback();
          document.querySelector('.paranja').remove();
          modalWrapper.remove();
        } else if (e.target.getAttribute('class') == 'modalCancel') {
          document.querySelector('.paranja').remove();
          modalWrapper.remove();
        }
      });

    }

    removeForm() {
      document.querySelector('.modalWrapper').remove();
    }

    start() {
      this.activateParanja();
    }

  }

  var confirmation = new Confirmation();
  confirmation.start();



  function progressBar() {
    var elem = document.querySelector('.host-name');
    var width = 0;
  }



  var Descupdater = function(elem){
    this.elem = document.querySelectorAll(elem);
  }


  // '/var/script/hbackup/catchpass.sh '
  // Перевод коллекции в массив
  function toArray(coll){
    for (var i = 0, a = [], len = coll.length; i < len; i++) {
      a[i] = coll[i];
    }

    return a;
  }

  var handler = {
    ceilData: new Descupdater('.host-ceil-data'),
    button: new Descupdater('.node-details--update')
  };

  var itemData = toArray(handler.ceilData.elem);

  for (var i = 0, len = itemData.length; i < len; i++) {
    if (itemData[i].children[0].textContent.match(/^(([0-9]{1,3}\.*){3})[0-9]{1,3}$/g)) {
      var IPaddr = itemData[i].children[0].textContent;
    }
  }


  var ajaxPost = function(prop, val, node_id) {
    var node_id = node_id;
    var request = new XMLHttpRequest();

    request.onreadystatechange = function() {
      console.log( this.responseText );
    }

    request.open('POST', '../models/Exec.php');
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    request.send(prop + val + node_id);
  }



  handler.button.elem[0].addEventListener('click', function(e){
    e.preventDefault();



    ajaxPost('caramba=', 'Evgeny&node_id=', 424);


  });

  // request.open('POST', '../models/Exec.php');
  // request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  // request.send(prop + val + node_id);

  // console.log( dataItems );


});