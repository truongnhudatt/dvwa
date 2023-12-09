var a = forge;
var clientPublicKey = null;
var clientPrivateKey = null;
var keys = null;
const serverPubKey = "-----BEGIN PUBLIC KEY-----MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEApUQ0SPFCMYu/IrX28d7nhrV7rqL1sWl83NoyZYH9iYdcQOssJiQkMYNKxcsfDF2gKA6rrIscDhGjt/y5SI5iOv8LRzT6HgQvcdLJ7dZ0HBvhma3CeqixQ6sBzfxte+Z8iVyzXOWymJYDs8wz6Vljg4ValuvW7bdZBOWmnd2aAAPpnTYPYquIg6wz3uGnqHZgiBZ5IAcI0L1IetoKaA7oIWKTqigtZ0qmHP5ShpfHK14cNtg6SYLuIJoRzhhNer2zjDNcjPl/I3syYuPGrJTvVLWI1vdFYXLM/lEQkEyS8FnH7OyUWuRSuJZDJRG+4Jb8e9dzfyXH2y24Nhl7gPFa8QIDAQAB-----END PUBLIC KEY-----";
// Genkey RSA
keys || (console.time("Generate keys..."),
    keys = a.pki.rsa.generateKeyPair({
        bits: 1024,
        workers: 1
    }),
    clientPublicKey = a.pki.publicKeyToPem(keys.publicKey),
    clientPrivateKey = a.pki.privateKeyToPem(keys.privateKey),
    console.timeEnd("Generate keys..."));
// end genkey
async function fetchAllProduct() {
    try {
      let e = {};
      e = Object.assign({ clientPubKey: clientPublicKey }, e);
      var data = encrypt(e);
  
      const requestOptions = {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify(data)
      };
  
      const response = await fetch('get_all_data.php', requestOptions);
      const encryptedData = await response.json();
      const decryptedData = JSON.parse(decrypt(encryptedData));
  
      return decryptedData.data;
    } catch (error) {
      // Xử lý lỗi
      console.error('Lỗi khi gọi API:', error);
      throw error; // Ném lỗi để có thể xử lý ở nơi gọi hàm fetchAllProduct
    }
}


function encrypt(e) {
    const t = a.random.getBytesSync(32)
    , i = a.random.getBytesSync(16);
    const s = a.cipher.createCipher("AES-CTR", t);
    s.start({
        iv: i
    }),
    s.update(a.util.createBuffer(a.util.encodeUtf8(JSON.stringify(e)))),
    s.finish();
    const o = buffer.Buffer.concat([buffer.Buffer.from(i, "binary"), buffer.Buffer.from(s.output.data, "binary")]);
    const r = a.pki.publicKeyFromPem(serverPubKey).encrypt(a.util.encode64(t));
    return data = {
        d: o.toString("base64"),
        k: a.util.encode64(r),
    };
}
function decrypt(e) {
    const {k: t, d: i} = e
      , s = a.pki.privateKeyFromPem(clientPrivateKey)
      , o = a.util.decodeUtf8(s.decrypt(a.util.decode64(t)))
      , r = buffer.Buffer.from(i, "base64")
      , c = r.slice(0, 16)
      , l = r.slice(16)
      , h = a.cipher.createDecipher("AES-CTR", buffer.Buffer.from(o, "base64").toString("binary"));
    return h.start({
        iv: c.toString("binary")
    }),
    h.update(a.util.createBuffer(l)),
    h.finish(),
    a.util.decodeUtf8(h.output.data)
}
function submit(urlImage){
    
    var query = document.querySelector(".query").value;
    const url = 'handle.php';
    let e = {
        data: query
    };
    e = Object.assign({
        clientPubKey: clientPublicKey
    }, e);
    var data = encrypt(e);
    const requestOptions = {
    method: 'POST', 
    headers: {
        'Content-Type': 'application/json',
    },
    body: JSON.stringify(data) // Chuyển đổi đối tượng JSON thành chuỗi
    };

    fetch(url, requestOptions)
    .then(response => response.json()) // Chuyển đổi phản hồi thành đối tượng JSON
    .then(data => {
        responseData = decrypt(data);
        document.querySelector(".query").value = '';
        var message = JSON.parse(responseData).message;
        var code = JSON.parse(responseData).code;
        if(code == 200){
            document.querySelector(".query-result").innerHTML = `Kết quả tìm kiếm '${query}'`;
            var childDivs = document.getElementsByClassName('product');

            // Xóa hết phần tử trong list cũ đi.
            var productList = document.querySelector('.product-container');

            var childDivsArray = Array.from(childDivs);
            childDivsArray.forEach(function(childDiv) {
                childDiv.parentNode.removeChild(childDiv);
                // Hoặc sử dụng childDiv.remove(); nếu trình duyệt hỗ trợ
            });
            var products = message;

            for (var i = 0; i < products.length; i++) {
                let product = products[i];
                var productDiv = document.createElement('div');
                productDiv.className = 'product';

                var productImageDiv = document.createElement('div');
                productImageDiv.className = 'product-image';
                var image = document.createElement('img');
                image.src = `${urlImage}${products[i].link_image}`;
                image.alt = '';
                productImageDiv.appendChild(image);

                var productDetailsDiv = document.createElement('div');
                productDetailsDiv.className = 'product-details';
                var nameHeader = document.createElement('h3');
                nameHeader.textContent = products[i].name;
                var ratingDiv = document.createElement('div');
                ratingDiv.className = 'rating';
                var truncateTextDiv = document.createElement('div');
                truncateTextDiv.className = 'truncate-text';
                truncateTextDiv.textContent = products[i].des;
                var link = document.createElement('a');
                link.href = '#';
                link.textContent = 'Xem chi tiết';
                productDetailsDiv.appendChild(nameHeader);
                productDetailsDiv.appendChild(ratingDiv);
                productDetailsDiv.appendChild(truncateTextDiv);
                productDetailsDiv.appendChild(link);

                // Thêm các phần tử vào productDiv
                productDiv.appendChild(productImageDiv);
                productDiv.appendChild(productDetailsDiv);

                productList.appendChild(productDiv);
            }
        }
        else {
            document.querySelector(".query-result").innerHTML = `Nội dung tìm kiếm chứa các kí tự không hợp lệ`;
        }     
        console.log('Dữ liệu nhận được từ API:',code);
    })
    .catch(error => {
        console.error('Lỗi khi gọi API:', error);
    });
}