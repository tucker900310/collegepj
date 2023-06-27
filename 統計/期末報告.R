library(sjmisc)
library(data.table)
library(dplyr)
library(ggplot2)
library(ggpubr)
library(BSDA)
data <- fread("C:/Users/tucke/Documents/new_num.csv")
haveT <- data %>% filter(是否上過遠距 == '是')
notT  <- data %>% filter(是否上過遠距 == '否')
m<- data %>% filter(生理性別 == '男')
method<- data %>% filter(上課方式 == '直播'||上課方式 == '事先錄好的影片')


#---------------------------------------------------------------------
var.test(data$支持使用遠距, data$開鏡頭仍支持遠距)
z.test(data$開鏡頭仍支持遠距, alternative = "greater", sigma.x = 0.5, sigma.y = 0.5, conf.level = 0.95)
z.test(data$支持使用遠距, data$開鏡頭仍支持遠距, var.equal = F)
asbio::one.sample.z(data$讓我的成績 , null.mu = 3, sigma = sd(data$讓我的成績), alternative = "two.sided", conf = 0.95)
ggerrorplot(data, x = "上課發言頻率", y = "支持使用遠距", 
            desc_stat = "mean_ci" , palette="uchicago", size=.9) + 
  labs(x="上課發言頻率", y = "支持使用遠距", title= "Confidence interval graph of customer churn and credit limit") + 
  theme_minimal() + theme(axis.text.x = element_text(angle=90),text = element_text(size=20))
sum(is.na(haveT))
fm <- aov(支持使用遠距 ~ 是否上過遠距, data = data)
summary(fm)
haveT.lm <- lm(支持使用遠距 ~ 上課發言頻率+教授關係+同儕討論課業頻率,
                data = haveT)
summary(haveT.lm)
names(haveT.lm)
shapiro.test(haveT.lm$residual)
durbinWatsonTest(haveT.lm) 
ncvTest(haveT.lm)
autoplot(haveT.lm)

#---------------------------------------------------------------------
sum(is.na(notT))
notT.lm <- lm(支持使用遠距 ~ 上課發言頻率+教授關係+同儕討論課業頻率,
                     data = notT)
summary(notT.lm)
shapiro.test(notT.lm$residual)
durbinWatsonTest(notT.lm) 
ncvTest(notT.lm)
autoplot(notT.lm)

#---------------------------------------------------------------------
sum(is.na(data))
allT.lm <- lm(支持使用遠距 ~ 上課發言頻率+教授關係+同儕討論課業頻率,
                    data = data)
summary(allT.lm)
shapiro.test(allT.lm$residual)
durbinWatsonTest(allT.lm) 
ncvTest(allT.lm)
autoplot(allT.lm)

#---------------------------------------------------------------------
sum(is.na(haveT))
haveT.lm <- lm(支持使用遠距 ~ 讓我的成績+更能理解上課內容+學習更有效率+更常課後複習+更專注課堂,
                     data = haveT)
summary(haveT.lm)
names(haveT.lm)
shapiro.test(haveT.lm$residual)
durbinWatsonTest(haveT.lm) 
ncvTest(haveT.lm)
autoplot(haveT.lm)

#---------------------------------------------------------------------
sum(is.na(notT))
notT.lm <- lm(支持使用遠距 ~ 讓我的成績+更能理解上課內容+學習更有效率+更常課後複習+更專注課堂,
                    data = notT)
summary(notT.lm)
shapiro.test(notT.lm$residual)
durbinWatsonTest(notT.lm) 
ncvTest(notT.lm)
autoplot(notT.lm)

#---------------------------------------------------------------------
sum(is.na(data))
allT.lm <- lm(支持使用遠距 ~ 讓我的成績+更能理解上課內容+學習更有效率+更常課後複習+更專注課堂+上課發言頻率+教授關係+同儕討論課業頻率,
                    data = data)
summary(allT.lm)
shapiro.test(allT.lm$residual)
durbinWatsonTest(allT.lm) 
ncvTest(allT.lm)
autoplot(allT.lm)
#---------------------------------------------------------------------
dd <- aov(上課發言頻率 ~ 上課方式, data = data)
summary(dd)
ncvTest(dd)
g <- aov(支持使用遠距~ 學院, data = coloege)
summary(g)
ncvTest(g)

data <- data[complete.cases(data), ]
ggplot(data, aes(x = 上課方式, y = 學習更有效率)) +
  geom_boxplot(color = "red")+
  stat_summary(fun.y=mean, geom="point",pch=3,color="blue", size=5)
ggplot(data, aes(x =是否上過遠距 , y =更專注課堂 )) + geom_boxplot(width = .5)  
ggplot(data, aes(x =是否上過遠距 , y =更能理解上課內容 )) + geom_boxplot(width = .5)  

