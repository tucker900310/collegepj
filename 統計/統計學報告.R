library(sjmisc)
library(data.table)
library(dplyr)
library(ggplot2)
library(ggpubr)
library(BSDA)
bank<-read.csv("C:/Users/tucke/Documents/BankChurners_new.csv") 

still <- bank %>% filter(Attrition_Flag == 'Existing Customer')
lost <- bank %>% filter(Attrition_Flag == 'Attrited Customer')

shapiro.test(still$Total_Trans_Amt)
shapiro.test(lost$Total_Trans_Amt)

still_mean = mean(still$Total_Trans_Amt)
lost_mean = mean(lost$Total_Trans_Amt)
StransPmonth=still$Total_Trans_Ct/still$Months_on_book
LtransPmonth=lost$Total_Trans_Ct/lost$Months_on_book
bank$BPM<-bank$Total_Trans_Ct/bank$Months_on_book
bank$APM<-bank$Total_Trans_Amt/bank$Months_on_book


z.test(still$Total_Trans_Ct, lost$Total_Trans_Ct, alternative = "greater", sigma.x = 0.5, sigma.y = 0.5, conf.level = 0.95)
z.test(StransPmonth, LtransPmonth, alternative = "greater", sigma.x = 0.5, sigma.y = 0.5, conf.level = 0.95)
z.test(still$Credit_Limit, lost$Credit_Limit, alternative = "greater", sigma.x = 0.5, sigma.y = 0.5, conf.level = 0.95)
z.test(still$BPM, lost$BPM, alternative = "two.sided", sigma.x = 0.5, sigma.y = 0.5, conf.level = 0.95)
z.test(lost$APM,still$APM,  alternative = "less", sigma.x = 0.5, sigma.y = 0.5, conf.level = 0.95)

ggplot(bank, aes(x = Attrition_Flag, y = Total_Trans_Amt)) +
  geom_boxplot(color = "red")+

  geom_jitter(position = position_jitter(0.05))


ggplot(data, aes(x = Attrition_Flag, y = Total_Trans_Ct)) +
  geom_boxplot(color = "red")+
  stat_summary(fun.y=mean, geom="point",pch=3,color="blue", size=5)+
  geom_jitter(position = position_jitter(0.05))



ggplot(data, aes(x = Attrition_Flag, y =bank$BPM)) +
  geom_boxplot(color = "red")+
  stat_summary(fun.y=mean, geom="point",pch=3,color="blue", size=5)+
  geom_jitter(position = position_jitter(0.05))
t.test(still$Total_Trans_Ct, lost$Total_Trans_Ct, var.equal = F)
t.test(still$Total_Trans_Amt, lost$Total_Trans_Amt, var.equal = F)

ggplot(data, aes(x = Attrition_Flag, y =bank$APM)) +
  geom_boxplot(color = "red")+
  stat_summary(fun.y=mean, geom="point",pch=3,color="blue", size=5)+
  geom_jitter(position = position_jitter(0.05))
t.test(still$Total_Trans_Ct, lost$Total_Trans_Ct, var.equal = F)
t.test(still$Total_Trans_Amt, lost$Total_Trans_Amt, var.equal = F)

ggplot(data, aes(x = Attrition_Flag, y =Credit_Limit)) +
  geom_boxplot(color = "red")+
  stat_summary(fun.y=mean, geom="point",pch=3,color="blue", size=5)+
  geom_jitter(position = position_jitter(0.05))
t.test(still$Total_Trans_Ct, lost$Total_Trans_Ct, var.equal = F)
t.test(still$Total_Trans_Amt, lost$Total_Trans_Amt, var.equal = F)

ci = function(x, alpha=0.05) {
  n = length(x) # n = 樣本數
  S = sqrt(var(x)) # S 即為標準差的點估計
  r = qt(1-alpha/2, df=n-1)
  range = c(r*S/sqrt(n))
  return(range)
}
test_ci = bank %>% group_by(Attrition_Flag) %>% summarise(mean = mean(Total_Trans_Amt),ci = ci(Total_Trans_Amt)) 
test_ci %>% ggplot(aes(y = mean, x = Attrition_Flag))+
  geom_point(size = 5, alpha = 0.5)+
  geom_errorbar(width = 0.1, aes(ymin = mean-ci, ymax = mean+ci), colour = "darkred")+ 
  labs(x = "Attrited customers and existing customers",y = "Total_Trans_Amt", title ="Estimated interval between Attrited customers and existing customers for the Total_Trans_Amt") 


test_ci = bank %>% group_by(Attrition_Flag) %>% summarise(mean = mean(Total_Trans_Ct),ci = ci(Total_Trans_Ct)) 
test_ci %>% ggplot(aes(y = mean, x = Attrition_Flag))+
  geom_point(size = 5, alpha = 0.5)+
  geom_errorbar(width = 0.1, aes(ymin = mean-ci, ymax = mean+ci), colour = "darkred")+ 
  labs(x = "Attrited customers and existing customers",y = "Total_Trans_Ct",  title ="Estimated interval between Attrited customers and existing customers for the Total_Trans_Ct") 

test_ci = bank %>% group_by(Attrition_Flag) %>% summarise(mean = mean(BPM),ci = ci(BPM)) 
test_ci %>% ggplot(aes(y = mean, x = Attrition_Flag))+
  geom_point(size = 5, alpha = 0.5)+
  geom_errorbar(width = 0.1, aes(ymin = mean-ci, ymax = mean+ci), colour = "darkred")+ 
  labs(x = "Attrited customers and existing customers",y = "Total_Trans_Ct per month", title ="Estimates interval of the average number of transactions per month between lost customers and existing customers") 

test_ci = bank %>% group_by(Attrition_Flag) %>% summarise(mean = mean(APM),ci = ci(APM)) 
test_ci %>% ggplot(aes(y = mean, x = Attrition_Flag))+
  geom_point(size = 5, alpha = 0.5)+
  geom_errorbar(width = 0.1, aes(ymin = mean-ci, ymax = mean+ci), colour = "darkred")+ 
  labs(x = "Attrited customers and existing customers",y = "Total_Trans_At per month", title ="Estimates interval of the average Trans_Amt per month between lost customers and existing customers") 

test_ci = bank %>% group_by(Attrition_Flag) %>% summarise(mean = mean(Credit_Limit),ci = ci(Credit_Limit)) 
test_ci %>% ggplot(aes(y = mean, x = Attrition_Flag))+
  geom_point(size = 5, alpha = 0.5)+
  geom_errorbar(width = 0.1, aes(ymin = mean-ci, ymax = mean+ci), colour = "darkred")+ 
  labs(x = "Attrited customers and existing customers",y = "Credit_Limit", title ="Estimates interval of tCredit_Limit between lost customers and existing customers")   

ggerrorplot(bank, x = "Attrition_Flag", y = "Credit_Limit", 
            desc_stat = "mean_ci" , palette="uchicago", size=.9) + 
  labs(x="Attrition_Flag", y = "Credit_Limit", title= "Confidence interval graph of customer churn and credit limit") + 
  theme_minimal() + theme(axis.text.x = element_text(angle=90),text = element_text(size=20))

