#  Fully Automated CI/CD Pipeline

Built a **fully automated CI/CD pipeline** using AWS services! This project demonstrates the power of **continuous integration and continuous deployment**, ensuring smooth and reliable application delivery.


##  Technologies Used
 Leveraged the following **AWS tools** to automate our pipeline:
- **AWS CodeCommit** → Source control for managing our application code  
- **AWS CodeBuild** → Automates the build process  
- **AWS CodeDeploy** → Handles deployment to production  
- **Amazon S3** → Stores build artifacts securely  
- **Amazon EC2** → Hosts the application  

---

## 🔧 CI/CD Pipeline Workflow
### **1️⃣ Code Commit (AWS CodeCommit)**
Developers push code changes to **AWS CodeCommit**, triggering the pipeline.

### **2️⃣ Build Process (AWS CodeBuild)**
- The code is pulled from the repository  
- Dependencies are installed  
- Code is built and tested  
- The final artifact is stored in **Amazon S3**  

### **3️⃣ Deployment (AWS CodeDeploy)**
- CodeDeploy fetches the latest build from **S3**  
- Deploys it to **Amazon EC2** instances  
- Ensures **zero downtime** with rolling updates

### Architecture Diagram
![image](https://github.com/user-attachments/assets/04e69532-28f7-4b39-95b8-38c949db7e2d)

