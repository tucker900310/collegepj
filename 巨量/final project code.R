rm(list=ls(all=T))
pacman::p_load(magrittr, readr, caTools, ggplot2, dplyr, vcd,
               tidyr,data.table,stringr, randomForest,sjmisc,
               rpart,rpart.plot,caret,pROC,smotefamily,ranger,
               sampling,ISLR,partykit) #載入套件
              
###資料處理
steam = fread("data/steam.csv", encoding = 'UTF-8', header = T)
#移除重複遊戲
steam <- steam %>% group_by(name) %>% filter(!duplicated(name))
##日期格式轉換
steam$release_date = as.Date(steam$release_date, format="%m/%d/%Y")
steam %>% filter(year(release_date) > 2013 ) %>% nrow() #25201筆資料集中在2013年後，佔資料總數93%
hist(steam$release_date,'year',freq=T,las=2)
steam = subset(steam,release_date > as.Date("2013-12-31") )
#移除不支援英語的遊戲
steam <- subset(steam,english == 1)
##新增欄位判斷是否為免費遊戲
steam$isFree <- ifelse(steam$price==0, TRUE, FALSE)
##新增正面評論率欄位
steam <- steam %>% mutate(positive_percentage= positive_ratings / (positive_ratings+negative_ratings))
##刪除不支援windows遊戲
steam <- steam %>% filter(grepl("windows",`platforms`))
####分類owners
####觀察owners分布
table(steam$owners)
#####將資料分成4類
steam$owners <- rec(steam$owners, rec = "20000-50000 = 1;50000-100000 = 1;100000-200000 = 1; 200000-500000 = 2;
                    500000-1000000 = 2; 1000000-2000000 = 3; 2000000-5000000 = 3; 5000000-10000000 = 3;
                    10000000-20000000 = 3; 20000000-50000000 = 3; 50000000-100000000 = 3; 0-20000 = 0", as.num = T)


##篩選重要特徵category

categories <- data.frame(x=unlist( str_split(steam$categories, ";")))

setDT(categories)[, .(freq = .N), x] %>% arrange(freq)

#新增category欄位
steam$SinglePlayer <- grepl("Single-player",steam$categories)#支援單人
steam$isControllerSupport <- grepl("controller|Controller",steam$categories)#支援控制器
steam$isSteamCloud <- grepl("Steam Cloud",steam$categories)#支援steamCloud
steam$isTradingCards <- grepl("Trading Cards",steam$categories)#steam內玩遊戲獲得卡片
steam$isLeaderboards <- grepl("Leaderboards",steam$categories)#遊戲排行榜
steam$isHaveStats <- grepl("Stats",steam$categories)#追蹤遊戲統計資料
steam$InAppPurchases <- grepl("In-App Purchases",steam$categories)#應用程式內購買
steam$VRSupport <- grepl("VR Support",steam$categories)#支援VR
steam$CaptionsAvailable <- grepl("Captions available",steam$categories)#字幕支援
steam$MultiPlayer <- grepl("Multi-player",steam$categories) #支援多人
steam$AntiCheat <- grepl("Valve Anti-Cheat enabled",steam$categories)#防作弊

#新增genres欄位
genres <- data.frame(x=unlist( str_split(steam$genres, ";")))
setDT(genres)[, .(freq = .N), x] %>% arrange(freq)
#######################

#移除非遊戲資料
steam <- steam %>% filter(grepl("Documentary",genres)==FALSE)
steam <-steam %>% filter(grepl("Tutorial",genres)==FALSE) 
steam <-steam %>% filter(grepl("Accounting",genres)==FALSE) 
steam <- steam %>% filter(grepl("Photo Editing",genres)==FALSE) 
steam <- steam %>% filter(grepl("Game Development",genres)==FALSE) 
steam <- steam %>% filter(grepl("Web Publishing",genres)==FALSE)
steam <- steam %>% filter(grepl("Software Training",genres)==FALSE)
steam <- steam %>% filter(grepl("Audio Production",genres)==FALSE)
steam <- steam %>% filter(grepl("Video Production",genres)==FALSE) 
steam <- steam %>% filter(grepl("Education",genres)==FALSE)
steam <- steam %>% filter(grepl("Animation & Modeling",genres)==FALSE)
steam <-steam %>% filter(grepl("Design & Illustration",genres)==FALSE) 
steam <- steam %>% filter(grepl("Audio Production",genres)==FALSE) 
steam <- steam %>% filter(grepl("Utilities",genres)==FALSE) 

steam$isIndie <- grepl("Indie",steam$genres)
steam$isAction <- grepl("Action",steam$genres)
steam$isCasual <- grepl("Casual",steam$genres)
steam$isAdventure <- grepl("Adventure",steam$genres)
steam$isStrategy <- grepl("Strategy",steam$genres)
steam$isSimulation <- grepl("Simulation",steam$genres)
steam$isRPG <- grepl("RPG",steam$genres)
steam$isEarlyAccess <- grepl("Early Access",steam$genres)
steam$isSports <- grepl("Sports",steam$genres)
steam$isRacing <- grepl("Racing",steam$genres)
steam$isViolent <- grepl("Violent",steam$genres)
steam$isGore <- grepl("Gore",steam$genres)
steam$isNudity <- grepl("Nudity",steam$genres)
steam$isSexualContent <- grepl("Sexual Content",steam$genres)
#####################################
#新增pulisher欄位
# publishers <- data.frame(x=unlist( str_split(steam$publisher, ";")))
# 
# setDT(publishers)[, .(freq = .N), x] %>% filter(freq > 10) %>% arrange(freq) %>% tail(10)
# ####觀察出版商對遊戲銷量的影響
# tapply(steam$year_owners,steam$publisher,mean) %>% sort() %>% head(20)
# #####發現出版商對銷量沒有太大的影響
# #############
# steam$BigFishGames <- grepl("Big Fish Games",steam$publisher);
# steam$PlugInDigital <- grepl("Plug In Digital",steam$publisher);
# steam$SekaiProject <- grepl("Sekai Project",steam$publisher);
# steam$StrategyFirst <- grepl("Strategy First",steam$publisher);
# steam$ChoiceOfGames <- grepl("Choice of Games",steam$publisher);
# steam$NightdiveStudios <- grepl("Nightdive Studios",steam$publisher);
# steam$DagestanTechnology <- grepl("Dagestan Technology",steam$publisher);
# steam$KISSltd <- grepl("KISS ltd",steam$publisher);
# steam$Degica <- grepl("Degica",steam$publisher);
# steam$AGMPLAYISM <- grepl("AGM PLAYISM",steam$publisher);
# 
#############
steam$owners = gsub('0','unpopular',steam$owners)
steam$owners = gsub('1','normal',steam$owners)
steam$owners = gsub('2','hot',steam$owners)
steam$owners = gsub('3','bestseller',steam$owners)
steam <- steam %>% mutate_if(is.logical, as.factor) 
steam <- steam[complete.cases(steam),]

steam$owners <- as.factor(steam$owners)
steam$owners<- as.character(steam$owners)
cols <- sapply(steam, is.factor)
steam[,cols] <- lapply(steam[,cols], as.logical)
cols2 <- sapply(steam, is.logical)
steam[,cols2] <- lapply(steam[,cols], as.numeric)
save(steam,file="C:/Users/tucke/Documents/bigdata/Prep_steam.rdata")
#########################################
##########################################
##導入資料
load("C:/Users/tucke/Documents/bigdata/Prep_steam.rdata")
summary(steam)
steam$owners <- as.factor(steam$owners)
########篩選需要欄位
steam_df <- steam[,c(8,12,17:19,21:45)]


##################################################
####分割資料train 0.7 test 0.3
set.seed(22)
index <-  sample(1:nrow(steam_df), nrow(steam_df) * 0.7)
train_set <- steam_df[index, ]
test_set <-  steam_df[-index, ]
#檢視train owners 分布，類別不平衡嚴重
table(train_set$owners)###查看資料分布
#使用smote平衡類別
set.seed(50)
sum(is.na(train_set))
smote <- SMOTE(train_set[,-3],train_set[,-3],K=4,dup_size = 20)
table(smote$data$class)###查看平衡後資料分布

########1.初始模型
ctrl <- trainControl(method = "repeatedcv",
                     number = 10,
                     repeats = 3,
                     summaryFunction = multiClassSummary,
                     classProbs = TRUE,)
set.seed(42)
orig_fit <- train(class ~ .,
                  data = smote$data,
                  method = "rf",
                  trControl = ctrl)
orig_fit
plot(orig_fit)##acc隨參數變化
plot(orig_fit,metric="Kappa")#Kappa值隨參數變化
orig_fit$finalModel$importance###查看變數重要性

#########2.以ranger包建構模型
set.seed(22)
index <-  sample(1:nrow(steam_df), nrow(steam_df) * 0.7)
train_set <- steam_df[index, ]
test_set <-  steam_df[-index, ]
set.seed(50)
smote <- SMOTE(train_set[,-3],train_set[,3],K=4,dup_size = 20)
table(smote$data$class)###查看平衡後資料分布

ctrl <- trainControl(method = "repeatedcv",
                     number = 10,
                     repeats = 3,
                     summaryFunction = multiClassSummary,
                     classProbs = TRUE,)
set.seed(42)
ranger_fit <- train(class ~ .,
                  data = smote$data,
                  method = "ranger",
                  importance = "permutation",
                  trControl = ctrl)
ranger_fit
plot(ranger_fit)##acc隨參數變化
varImp(ranger_fit)

#########3.訓練最終模型
set.seed(22)
index <-  sample(1:nrow(steam_df), nrow(steam_df) * 0.7)
train_set <- steam_df[index, ]
test_set <-  steam_df[-index, ]
set.seed(50)
smote <- SMOTE(train_set[,-3],train_set[,3],K=4,dup_size = 20)

ctrl <- trainControl(method = "none",
                     summaryFunction = multiClassSummary,
                     classProbs = TRUE,)
set.seed(42)
final_fit <- train(class ~ .,
                    data = smote$data,
                    method = "rf",
                    tuneGrid = orig_fit$bestTune,
                    trControl = ctrl)
final_fit$results
#######預測資料
test_set$predict <- predict(final_fit,test_set)
result <- predict(final_fit, newdata = test_set)
confusionMatrix(result, test_set$owners)
im <- final_fit$finalModel$importance %>% as.data.frame()
im %>% arrange(MeanDecreaseGini)
####ROC
pred <- predict(final_fit,test_set,type="prob")
roc <- multiclass.roc(test_set$owners,pred[,1])
roc#0.7656
plot(roc$rocs[[1]],col="blue")
plot.roc(roc$rocs[[2]],add=TRUE,col="red")
plot.roc(roc$rocs[[3]],add=TRUE,col="green")
plot.roc(roc$rocs[[4]],add=TRUE,col="yellow")
plot.roc(roc$rocs[[5]],add=TRUE,col="pink")
plot.roc(roc$rocs[[6]],add=TRUE,col="gray")


#決策樹
steam$release_date = year(steam$release_date)
# 將資料70%分為train_set，30%分為test_set
steam$owners = as.factor(steam$owners)
set.seed(22)
index <-  sample(1:nrow(steam), nrow(steam) * 0.7)
train_set <- steam[index, ]
test_set <-  steam[-index, ]
# 由於變數太多，我先分別就category、genre和publisher中找出較重要變數
# 從category中找出較重要變數
GameSale_cat <- rpart(owners ~ SinglePlayer + isControllerSupport + isSteamCloud + isTradingCards 
                      + isLeaderboards + isHaveStats + InAppPurchases + VRSupport + CaptionsAvailable 
                      + MultiPlayer + AntiCheat, data = train_set, control = rpart.control(cp = 0.001))
summary(GameSale_cat) # 在category中，isTradingCards、InAppPurchases、isSteamCloud為較重要變數

# 從publisher中找出較重要變數
GameSale_pub <- rpart(owners ~ BigFishGames + PlugInDigital + SekaiProject + StrategyFirst 
                      + ChoiceOfGames + NightdiveStudios + DagestanTechnology + KISSltd 
                      + Degica + AGMPLAYISM, data = train_set, control = rpart.control(cp = 0.001))
summary(GameSale_pub) # 在publisher中，KISSltd為較重要變數

# 刪除資料中多餘的變數
train_set_df = train_set[,c(3, 17, 19, 20, 23, 24, 27, 53)]
test_set_df = test_set[,c(3, 17, 19, 20, 23, 24, 27, 53)]

GameSale <- rpart(owners ~ positive_percentage + release_date + isFree + isTradingCards 
                  + InAppPurchases + KISSltd + isSteamCloud, data = train_set_df)

summary(GameSale)
plot.party(as.party(GameSale))

rpart.rules(x = GameSale, cover = TRUE)
rpart.plot(GameSale, faclen = 0, fallen.leaves = TRUE, shadow.col = "gray", extra = 2)

# predict
test_set_df$predict <- predict(GameSale,test_set_df)#預測
pred <- predict(GameSale,newdata=test_set_df, type = "class")
pred_2 <- predict(GameSale,newdata=test_set_df, type = "prob")

roc <- multiclass.roc(test_set_df$owners,pred_2[,4]) ####繪製多分類ROC
roc
plot(roc$rocs[[1]],col="blue")
plot.roc(roc$rocs[[2]],add=TRUE,col="red")
plot.roc(roc$rocs[[3]],add=TRUE,col="green")
plot.roc(roc$rocs[[4]],add=TRUE,col="yellow")
plot.roc(roc$rocs[[5]],add=TRUE,col="pink")
plot.roc(roc$rocs[[6]],add=TRUE,col="gray")
cm <- table(test_set_df$owners, pred, dnn = c("實際", "預測"))
cm






