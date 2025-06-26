
---

````markdown
# 🌍 AWS Capstone Final Project: Multi-Region CI/CD-Driven Application with Disaster Recovery

This repository delivers a production-ready, **multi-tier, multi-region web application** built with automation, high availability, and disaster recovery at its core. It combines modern CI/CD practices with a robust cloud-native architecture, deploying a **PHP frontend** and **Python/Flask backend** on **Amazon EKS**, with **Amazon RDS (MySQL)** powering persistent storage.

---

## 🚀 Project Highlights

- **Frontend:** PHP app deployed on Amazon EKS (via Kubernetes).
- **Backend:** Flask (Python) microservice also on EKS.
- **Database:** Amazon RDS (MySQL, Multi-AZ) for high availability.
- **CI/CD:** Full automation with AWS CodePipeline and CodeBuild.
- **Security:** Trivy for container scanning, SonarQube for static analysis.
- **Monitoring:** Centralized logs and alerts with Amazon CloudWatch.
- **Multi-Region DR:** Active-Passive setup using Route 53 failover.
- **IaC:** Infrastructure managed using CloudFormation and Terraform.

---

## 🧠 Architecture Overview

This solution spans **two AWS regions**:

- **Primary Region:** `us-east-1`
- **Disaster Recovery Region:** `us-west-1`

```text
                +--------------------+
                |     GitHub Repo    |
                +---------+----------+
                          |
                          ▼
                +--------------------+
                |    AWS CodeBuild   |
                +---------+----------+
                          |
                          ▼
                +--------------------+
                |        ECR         |
                +---------+----------+
                          |
                          ▼
                +--------------------+
                |       EKS          |
                +--------------------+
````

* EKS services run in both regions.
* RDS uses cross-region snapshot or replication.
* Route 53 manages traffic routing and failover with health checks.

---

## ✨ Key Features

### ✅ CI/CD Automation

* **Trigger:** GitHub pushes via CodeStar Connections.
* **Build:** Dockerize apps, run static and security scans.
* **Deploy:** Apply Kubernetes manifests to EKS.
* **Artifacts:** Store images in Amazon ECR.

### 🔍 SonarQube Integration

* Performs **static code analysis** for PHP and Python code.
* Ensures code quality, detects bugs, and flags vulnerabilities.
* Integrated in the CodeBuild phase of CI/CD.

### 🛡️ Trivy Image Scanning

* Scans Docker images during the build phase.
* Detects vulnerabilities (CVEs) in system packages and libraries.
* Critical vulnerabilities can stop the deployment pipeline.

### 🌐 Route 53 Failover Routing

* Configured with **failover routing policies**.
* Monitors health of endpoints in both regions.
* Automatically redirects traffic to `us-west-1` if `us-east-1` becomes unhealthy.
* Provides near-zero downtime disaster recovery.

### 📊 Amazon CloudWatch Monitoring

* Collects logs from EKS, CodeBuild, RDS, and VPC.
* Dashboards show CPU, memory, error rates.
* **CloudWatch Alarms** trigger alerts via SNS (email, Slack, etc.)

  * EKS Node CPU > 75%
  * RDS CPU/memory utilization
  * App latency/error spikes

---

## 🔧 AWS Services Used

| Category   | Services                                          |
| ---------- | ------------------------------------------------- |
| Networking | VPC, Subnets, IGW, NAT Gateway                    |
| Compute    | Amazon EKS, EC2 for worker nodes                  |
| Containers | Amazon ECR                                        |
| Database   | Amazon RDS for MySQL (Multi-AZ, Cross-Region DR)  |
| CI/CD      | CodePipeline, CodeBuild, CodeStar Connections     |
| Monitoring | Amazon CloudWatch (Logs, Alarms), Amazon SNS      |
| DNS & DR   | Amazon Route 53 (Health checks, Failover Routing) |
| Security   | IAM, Security Groups, Trivy, SonarQube            |
| IaC        | CloudFormation (Primary), Terraform (DR Region)   |

---

## 🔄 CI/CD Pipeline Flow

1. **Source (GitHub)**
   Pushing code triggers the pipeline.

2. **Build (CodeBuild)**

   * SonarQube static code analysis
   * Trivy container image scanning
   * Docker image build and artifact creation

3. **Push (ECR)**

   * Push validated images to Amazon ECR

4. **Deploy (EKS)**

   * Apply Kubernetes manifests
   * Use rolling updates for zero-downtime deployment

---

## 🛡️ Disaster Recovery Strategy

* **Active-Passive Design**
* **Primary Region:** `us-east-1` handles live traffic
* **Disaster Region:** `us-west-1` mirrors infra, ready to take over
* **RDS:** Cross-region read replica or snapshot restore
* **EKS:** Pre-provisioned cluster ready to scale
* **Route 53:** Failover DNS routing via health checks

---

## ⚙️ Setup Instructions

### 🔧 Prerequisites

* AWS account & CLI configured
* Docker, Terraform, and `kubectl` installed
* GitHub CodeStar Connection created

### 📦 Clone the Repository

```bash
git clone https://github.com/ThakurSahilSingh/Capstone-Project.git
cd Capstone-Project
```

### 🌍 Deploy Primary Region (`us-east-1`)

* Provision VPC, subnets, NAT/IGW
* Deploy EKS and RDS
* Configure IAM, CodePipeline, CodeBuild, ECR

### 🆘 Deploy Disaster Recovery Region (`us-west-1`)

```bash
cd terraform/dr-region
terraform init
terraform apply
```

* Sets up mirrored infrastructure in DR region

### 🧭 Configure Route 53

* Setup health checks for load balancers in both regions
* Configure failover routing policy
* Test DNS switch during simulated failure

---

## 📁 Project Structure

```text
Capstone-Project/
├── terraform/
│   └── dr-region/     # Terraform configs for DR region
├── manifests/         # Kubernetes deployment files
├── buildspec.yaml     # CodeBuild instructions
├── scripts/           # Utility scripts
├── sonar-project.properties  # SonarQube config
└── README.md
```

---

## 🤝 Contributing

Contributions are welcome! Please:

1. Fork this repository
2. Create a feature branch
3. Submit a pull request

---

## 📜 License

This project is licensed under the [MIT License](LICENSE).

---

## 📬 Contact

**Maintainer:** [Thakur Sahil Singh](https://github.com/ThakurSahilSingh)
For any issues, suggestions, or improvements—feel free to raise an issue or submit a PR.

```

