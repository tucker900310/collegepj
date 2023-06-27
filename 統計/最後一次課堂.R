library(sjmisc)
library(data.table)
library(dplyr)
library(ggplot2)
library(ggpubr)
library(BSDA)
library(car)
library(ggfortify)
bank<-read.csv("C:/Users/tucke/Documents/BankChurners_new.csv") 
bank$AmtPerMonth<-bank$Total_Trans_Amt/bank$Months_on_book
bank$CtPerMonth<-bank$Total_Trans_Ct/bank$Months_on_book
bank$AdC<-bank$Total_Trans_Amt/bank$Total_Trans_Ct

bank$Income <- rec(bank$Income_Category, rec = "Less than $40K = 40000; $40K - $60K = 50000; $60K - $80K = 70000; $80K - $120K = 100000; $120K + = 120000", as.character= T)
bank$Gender2 <- rec(bank$Gender, rec = "M = 1;F = 0", as.num = T)
ggplot(data=bank) + 
  geom_point(aes(x=Total_Revolving_Bal,
                 y=APM,
                 color=Total_Revolving_Bal))
sum(is.na(bank))
allT.lm <- lm(AmtPerMonth ~ Gender+CtPerMonth+Customer_Age+Total_Relationship_Count+Credit_Limit,
                     data = bank)
summary(allT.lm)

names(allT.lm)
shapiro.test(allT.lm$residual)
durbinWatsonTest(allT.lm) 
ncvTest(allT.lm)
autoplot(allT.lm)

#---------------------------------------------------------------------
ggplot(data=bank) + 
  geom_point(aes(x=Credit_Limit,
                 y=CtPerMonth,
                 color=Credit_Limit))
sum(is.na(bank))
bank <- bank[complete.cases(bank), ]
sum(is.na(bank))

allT.lm <- lm(CtPerMonth ~ Gender+AmtPerMonth+Customer_Age+Total_Relationship_Count+Credit_Limit,
              data = bank)
summary(allT.lm)

names(allT.lm)
shapiro.test(allT.lm$residual)
durbinWatsonTest(allT.lm) 
ncvTest(allT.lm)
autoplot(allT.lm)
#---------------------------------------------------------------------
sum(is.na(bank))
allT.lm <- lm(Total_Trans_Amt ~ Gender+Total_Trans_Ct+Customer_Age+Total_Relationship_Count+Months_on_book+Credit_Limit,
              data = bank)
summary(allT.lm)

names(allT.lm)
shapiro.test(allT.lm$residual)
durbinWatsonTest(allT.lm) 
ncvTest(allT.lm)
autoplot(allT.lm)
#---------------------------------------------------------------------

sum(is.na(bank))
allT.lm <- lm(AdC ~ Gender+Customer_Age+Total_Relationship_Count+Credit_Limit,
              data = bank)
summary(allT.lm)

names(allT.lm)
shapiro.test(allT.lm$residual)
durbinWatsonTest(allT.lm) 
ncvTest(allT.lm)
autoplot(allT.lm)