
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
- **Security:** Image scanning (Trivy), static code analysis (SonarQube).
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
* RDS has cross-region replica or snapshot-based replication.
* Route 53 handles failover with health checks.

---

## ✨ Key Features

### ✅ CI/CD Automation

* **Trigger:** GitHub pushes via CodeStar Connections.
* **Build:** Dockerize apps, run SonarQube & Trivy scans.
* **Deploy:** Apply Kubernetes manifests to EKS.
* **Artifacts:** Store images in Amazon ECR.

### 🌐 Multi-Region Disaster Recovery

* **Primary Active Region:** `us-east-1`
* **Passive DR Region:** `us-west-1` with pre-provisioned standby infra.
* **Failover Logic:**

  * Health checks via Route 53.
  * Route 53 re-routes DNS traffic upon failure detection.
  * RDS replica in DR is promoted, EKS is activated.

---

## 🔧 AWS Services Used

| Category   | Services                                            |
| ---------- | --------------------------------------------------- |
| Networking | VPC, Subnets, IGW, NAT Gateway                      |
| Compute    | Amazon EKS, EC2 for worker nodes                    |
| Containers | Amazon ECR                                          |
| Database   | Amazon RDS for MySQL (Multi-AZ, Cross-Region DR)    |
| CI/CD      | CodePipeline, CodeBuild, CodeStar Connections       |
| Monitoring | Amazon CloudWatch (Logs, Alarms), Amazon SNS        |
| DNS & DR   | Amazon Route 53 (Health checks, Failover Routing)   |
| Security   | IAM (Least Privilege), SGs, NACLs, Trivy, SonarQube |
| IaC        | CloudFormation (Primary), Terraform (DR Region)     |

---

## 🔄 CI/CD Pipeline Flow

1. **Source (GitHub)**
   Pushing code triggers the pipeline.

2. **Build (CodeBuild)**

   * Run SonarQube static analysis
   * Build Docker images
   * Run Trivy security scan

3. **Push (ECR)**

   * Push validated images to ECR

4. **Deploy (EKS)**

   * Apply Kubernetes manifests
   * Perform rolling updates

---

## 🛡️ Disaster Recovery Strategy

* **Active-Passive Design**
* **RDS:** MySQL replication or snapshot-based failover
* **EKS:** Standby infra is pre-provisioned
* **Route 53:**

  * Health checks on ALB/NLB
  * Auto-switch traffic to DR region

---

## 📈 Monitoring & Alerting

* **CloudWatch Logs**: App logs, VPC flow, load balancer access.
* **CloudWatch Alarms**:

  * EKS Node CPU > 75%
  * App error spikes
  * RDS connection/CPU alerts
* **Amazon SNS**: Sends alerts via email/Slack/other integrations.

---

## 🔐 Security Highlights

* IAM roles scoped with **least privilege**
* Private subnets for app and DB
* Trivy scans for containers during build
* SonarQube detects code-level vulnerabilities
* Network ACLs and SGs tightly controlled

---

## ⚙️ Setup Instructions (High-Level)

### 🔧 Prerequisites

* AWS account & CLI configured
* Docker & Terraform installed
* `kubectl` configured for EKS

### 📦 Clone the Repository

```bash
git clone https://github.com/ThakurSahilSingh/Capstone-Project.git
cd Capstone-Project
```

### 🌍 Deploy Primary Region (`us-east-1`)

* Create VPC, subnets, gateways via IaC
* Deploy EKS cluster & node groups
* Launch RDS (MySQL Multi-AZ)
* Set up CodePipeline & CodeBuild (linked to GitHub)
* Configure ECR, IAM, and Kubernetes manifests

### 🆘 Deploy Disaster Recovery Region (`us-west-1`)

```bash
cd terraform/dr-region
terraform init
terraform apply
```

* Creates mirrored VPC, EKS, RDS (replica)
* Optional: mirrored CI/CD for DR drills

### 🧭 Configure Route 53

* Hosted zone with failover routing policy
* Health checks for regional endpoints
* DNS automatically fails over to DR

---

## 📁 Project Structure

```text
Capstone-Project/
├── terraform/
│   └── dr-region/     # Terraform configs for DR region
├── manifests/         # Kubernetes deployment files
├── buildspec.yaml     # CodeBuild instructions
├── scripts/           # Utility scripts for setup/monitoring
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
For queries or collaboration, feel free to open an issue or submit a pull request.

```
