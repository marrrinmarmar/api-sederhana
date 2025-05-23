<!DOCTYPE html>
<html>
<head>
    <title>Portal Kependudukan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .button-group {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }
        button {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            flex: 1;
        }
        .submit-btn {
            background-color: #4CAF50;
            color: white;
        }
        .reset-btn {
            background-color: #f44336;
            color: white;
        }
        button:hover {
            opacity: 0.8;
        }
        .tabs {
            display: flex;
            margin-bottom: 20px;
            border-bottom: 1px solid #ddd;
        }
        .tab {
            padding: 10px 20px;
            cursor: pointer;
            border: 1px solid #ddd;
            border-bottom: none;
            border-radius: 4px 4px 0 0;
            margin-right: 5px;
        }
        .tab.active {
            background-color: #4CAF50;
            color: white;
        }
        .tab-content {
            display: none;
        }
        .tab-content.active {
            display: block;
        }
        #response {
            margin-top: 20px;
            padding: 10px;
            border-radius: 4px;
        }
        .success {
            background-color: #dff0d8;
            color: #3c763d;
        }
        .error {
            background-color: #f2dede;
            color: #a94442;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 style="text-align: center; margin-bottom: 20px;">Portal Kependudukan</h2>
        
        <div class="tabs">
            <div class="tab active" onclick="showTab('kependudukan')">Data Kependudukan</div>
            <div class="tab" onclick="showTab('pegawai')">Data Pegawai</div>
        </div>

        <div id="kependudukan" class="tab-content active">
            <form id="formKependudukan" onsubmit="return submitForm(event, 'kependudukan')">
                <div class="form-group">
                    <label for="nik_kependudukan">NIK:</label>
                    <input type="number" id="nik_kependudukan" name="nik" required>
                </div>
                <div class="form-group">
                    <label for="nama_kependudukan">Nama:</label>
                    <input type="text" id="nama_kependudukan" name="nama" required>
                </div>
                <div class="form-group">
                    <label for="alamat">Alamat:</label>
                    <input type="text" id="alamat" name="alamat" required>
                </div>
                <div class="button-group">
                    <button type="submit" class="submit-btn">Simpan</button>
                    <button type="reset" class="reset-btn">Reset</button>
                </div>
            </form>
        </div>

        <div id="pegawai" class="tab-content">
            <form id="formPegawai" onsubmit="return submitForm(event, 'pegawai')">
                <div class="form-group">
                    <label for="nik_pegawai">NIK:</label>
                    <input type="number" id="nik_pegawai" name="nik" required>
                </div>
                <div class="form-group">
                    <label for="nama_pegawai">Nama:</label>
                    <input type="text" id="nama_pegawai" name="nama" required>
                </div>
                <div class="form-group">
                    <label for="jabatan">Jabatan:</label>
                    <input type="text" id="jabatan" name="jabatan" required>
                </div>
                <div class="button-group">
                    <button type="submit" class="submit-btn">Simpan</button>
                    <button type="reset" class="reset-btn">Reset</button>
                </div>
            </form>
        </div>

        <div id="response"></div>
    </div>

    <script>
    function showTab(tabName) {
        // Hide all tab contents
        document.querySelectorAll('.tab-content').forEach(tab => {
            tab.classList.remove('active');
        });
        
        // Remove active class from all tabs
        document.querySelectorAll('.tab').forEach(tab => {
            tab.classList.remove('active');
        });
        
        // Show selected tab content
        document.getElementById(tabName).classList.add('active');
        
        // Add active class to clicked tab
        event.target.classList.add('active');
    }

    function submitForm(event, type) {
        event.preventDefault();
        
        const form = event.target;
        const formData = new FormData(form);
        const data = {
            type: type,
            data: Object.fromEntries(formData)
        };

        fetch('portalkependudukan.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(result => {
            const responseDiv = document.getElementById('response');
            if (result.status === 'success') {
                responseDiv.className = 'success';
                responseDiv.textContent = 'Data berhasil disimpan!';
                form.reset();
            } else {
                responseDiv.className = 'error';
                responseDiv.textContent = 'Error: ' + result.message;
            }
        })
        .catch(error => {
            const responseDiv = document.getElementById('response');
            responseDiv.className = 'error';
            responseDiv.textContent = 'Error: ' + error.message;
        });

        return false;
    }
    </script>
</body>
</html>