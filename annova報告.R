data <- fread("C:/Users/tucke/Documents/BankChurners_new.csv")
data$APM<-data$Total_Trans_Amt/data$Months_on_book
library(sjlabelled)
library(sjmisc)

data$marry2 <- rec(data$Marital_Status, rec = "Unknown = NA; else=copy", as.num = F)
interaction.plot(data$Gender, data$marry2, data$Total_Trans_Amt)
dd <- aov(Total_Trans_Amt ~ Gender * marry2, data = data)
summary(dd)


data$edu2 <- rec(data$Education_Level, rec = "Unknown = NA; else=copy", as.num = F)
interaction.plot(data$Gender, data$edu2, data$Total_Trans_Amt)
ff <- aov(Total_Trans_Amt ~ Gender * edu2, data = data)
summary(ff)
leveneTest(sqrt(Total_Trans_Amt) ~ Gender,data)
shapiro.test(sqrt(data$Total_Trans_Amt))
oneway.test(data$Total_Trans_Amt ~ data$Gender, data = data, var.equal = FALSE)

leveneTest(bank$APM ~ Gender,data)
shapiro.test(data$APM)
oneway.test(APM ~ data$Gender, data = data, var.equal = FALSE)

interaction.plot(data$Gender, data$Education_Level, data$Total_Trans_Amt)
fm <- aov(Total_Trans_Amt ~ Education_Level * Gender, data = data)
summary(fm)
TukeyHSD(fm)

interaction.plot(data$Gender, data$Marital_Status, data$Total_Trans_Amt)
fm <- aov(Total_Trans_Amt ~ Marital_Status * Gender, data = data)
summary(fm)
TukeyHSD(fm)

