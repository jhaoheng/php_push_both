//
//  ViewController.m
//  Apns_test
//
//  Created by jhaoheng on 2016/2/17.
//  Copyright © 2016年 max. All rights reserved.
//

#warning 從手機寄送 token 給 php api，寫入 log(日期、date)
#warning 加入兩個 btn , 1. request token(彈出 alert)

#import "ViewController.h"

@interface ViewController ()
{
    UILabel *token_label;
    
    UIScrollView *logView;
    
    UILabel *accept_times_label;
    int count;
}

@end

@implementation ViewController
@synthesize passToken=_passToken, passUserInfo=_passUserInfo;

#define infoBlockHeight 183;

- (void)setPassToken:(NSString *)passToken
{
    NSLog(@"token is : %@",passToken);
    
    _passToken = passToken;
    
    token_label.text = _passToken;
    [token_label sizeToFit];
}

- (void)setPassUserInfo:(NSDictionary *)passUserInfo
{
    
    NSDateFormatter *dateFormatter =[[NSDateFormatter alloc] init];
    [dateFormatter setDateFormat:@"yyyy-MM-dd HH:mm:SS"];
    [dateFormatter setTimeZone:[NSTimeZone systemTimeZone]];
    NSString *localeDate = [dateFormatter stringFromDate:[NSDate date]];
    
    //
    _passUserInfo = passUserInfo;
    
    //
    CGFloat h = infoBlockHeight;
    UILabel *infoLabel = [[UILabel alloc] initWithFrame:CGRectMake(0, logView.contentSize.height, CGRectGetWidth(logView.frame), h)];
    infoLabel.textColor = [UIColor whiteColor];
    infoLabel.text = [NSString stringWithFormat:@"%@\n%@",localeDate,_passUserInfo];
    infoLabel.numberOfLines = 0;
    infoLabel.lineBreakMode = NSLineBreakByCharWrapping;
    infoLabel.textAlignment = NSTextAlignmentLeft;
//    [infoLabel sizeToFit];
    [logView addSubview:infoLabel];
    
    logView.contentSize = CGSizeMake(logView.frame.size.width, logView.contentSize.height+h);
    
    [UIView beginAnimations:nil context:nil];
    logView.contentOffset = CGPointMake(0, logView.contentSize.height-h);
    [UIView commitAnimations];
    
    //接收次數
    count++;
    accept_times_label.text = [NSString stringWithFormat:@"Times : %d",count];
}

#pragma mark - view did load
- (void)viewDidLoad {
    [super viewDidLoad];
    self.view.backgroundColor = [UIColor whiteColor];
    // Do any additional setup after loading the view, typically from a nib.
    
    //系統版本
    NSDictionary* infoDictionary = [[NSBundle mainBundle] infoDictionary];
//    NSLog(@"%i Keys:  %@", [infoDictionary count], [[infoDictionary allKeys] componentsJoinedByString: @" ,"]);
    NSLog(@"CFBundleVersion : %@",[infoDictionary objectForKey:@"CFBundleVersion"]);
    NSLog(@"CFBundleShortVersionString : %@",[infoDictionary objectForKey:@"CFBundleShortVersionString"]);
    
    //
    UILabel *tokenTitle = [[UILabel alloc] initWithFrame:CGRectMake(10, 50, CGRectGetWidth(self.view.frame)-20, 0)];
    tokenTitle.text = @"Device Token is : ";
    [tokenTitle sizeToFit];
    [self.view addSubview:tokenTitle];
    
    //
    token_label = [[UILabel alloc] initWithFrame:CGRectMake(10, CGRectGetMaxY(tokenTitle.frame)+10, CGRectGetWidth(self.view.frame)-20, 60)];
    token_label.numberOfLines = 0;
    token_label.lineBreakMode = NSLineBreakByCharWrapping;
    token_label.text = @"hello, wait to get token.";
    [self.view addSubview:token_label];
    
    //uibutton mail token
    UIButton *mailTokenToSelf_btn = [UIButton buttonWithType:UIButtonTypeCustom];
    mailTokenToSelf_btn.frame = CGRectMake(10, CGRectGetMaxY(token_label.frame)+10, (CGRectGetWidth(self.view.frame)-30)/3, 44);
    [mailTokenToSelf_btn setTitle:@"mail Token" forState:UIControlStateNormal];
    [mailTokenToSelf_btn setTitleColor:[UIColor blackColor] forState:UIControlStateNormal];
    [mailTokenToSelf_btn addTarget:self action:@selector(pass_activity:) forControlEvents:UIControlEventTouchUpInside];
    mailTokenToSelf_btn.layer.cornerRadius = 10;
    mailTokenToSelf_btn.layer.borderColor = [UIColor blackColor].CGColor;
    mailTokenToSelf_btn.layer.borderWidth = .5;
    mailTokenToSelf_btn.titleLabel.font = [UIFont systemFontOfSize:12];
    [self.view addSubview:mailTokenToSelf_btn];
    
    //uibutton apiback token
    UIButton *apibackToken_btn = [UIButton buttonWithType:UIButtonTypeCustom];
    apibackToken_btn.frame = CGRectMake(CGRectGetMaxX(mailTokenToSelf_btn.frame)+5, CGRectGetMaxY(token_label.frame)+10, (CGRectGetWidth(self.view.frame)-30)/3, 44);
    [apibackToken_btn setTitle:@"apiback token" forState:UIControlStateNormal];
    [apibackToken_btn setTitleColor:[UIColor blackColor] forState:UIControlStateNormal];
    [apibackToken_btn addTarget:self action:@selector(apiToken_activity:) forControlEvents:UIControlEventTouchUpInside];
    apibackToken_btn.layer.cornerRadius = 10;
    apibackToken_btn.layer.borderColor = [UIColor blackColor].CGColor;
    apibackToken_btn.layer.borderWidth = .5;
    apibackToken_btn.titleLabel.font = [UIFont systemFontOfSize:12];
    [self.view addSubview:apibackToken_btn];
    
    //uibutton clean log
    UIButton *cleanLog_btn = [UIButton buttonWithType:UIButtonTypeCustom];
    cleanLog_btn.frame = CGRectMake(CGRectGetMaxX(apibackToken_btn.frame)+5, CGRectGetMaxY(token_label.frame)+10, (CGRectGetWidth(self.view.frame)-30)/3, 44);
    [cleanLog_btn setTitle:@"clean log" forState:UIControlStateNormal];
    [cleanLog_btn setTitleColor:[UIColor blackColor] forState:UIControlStateNormal];
    [cleanLog_btn addTarget:self action:@selector(cleanLog_activity:) forControlEvents:UIControlEventTouchUpInside];
    cleanLog_btn.layer.cornerRadius = 10;
    cleanLog_btn.layer.borderColor = [UIColor blackColor].CGColor;
    cleanLog_btn.layer.borderWidth = .5;
    cleanLog_btn.titleLabel.font = [UIFont systemFontOfSize:12];
    [self.view addSubview:cleanLog_btn];
    
    //次數
    count = 0;
    accept_times_label = [[UILabel alloc] initWithFrame:CGRectMake(10, CGRectGetMaxY(mailTokenToSelf_btn.frame)+5, CGRectGetWidth(self.view.frame)-20, 20)];
    accept_times_label.text = [NSString stringWithFormat:@"Times : %d",count];
    accept_times_label.textAlignment = NSTextAlignmentLeft;
    accept_times_label.textColor = [UIColor blackColor];
    [self.view addSubview:accept_times_label];
    
    //log scroll view
    [self init_logView];
}

- (void)didReceiveMemoryWarning {
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

#pragma mark - pass token
- (void)pass_activity:(id)sender
{
    
    NSString *subject = [NSString stringWithFormat:@"Hello,this is '%@ token'",[UIDevice currentDevice].name];
    NSString *msg = [NSString stringWithFormat:@"DeviceToken is : \n\n%@",_passToken];
    
    MFMailComposeViewController *mailCont = [[MFMailComposeViewController alloc] init];
    mailCont.mailComposeDelegate = self;
    
    [mailCont setSubject:subject];
//    [mailCont setToRecipients:[NSArray arrayWithObject:@""]];
    [mailCont setMessageBody:msg isHTML:NO];
    
    [self presentViewController:mailCont animated:YES completion:nil];
}


// Then implement the delegate method
- (void)mailComposeController:(MFMailComposeViewController*)controller didFinishWithResult:(MFMailComposeResult)result error:(NSError*)error
{
    [self dismissViewControllerAnimated:YES completion:nil];
}

#pragma mark - uiscroll view : log view
- (void)init_logView
{
    logView = [[UIScrollView alloc] initWithFrame:CGRectMake(10, CGRectGetMaxY(accept_times_label.frame)+10, CGRectGetWidth(self.view.frame)-20, CGRectGetHeight(self.view.frame)-CGRectGetMaxY(accept_times_label.frame)-20)];
    logView.backgroundColor = [UIColor blackColor];
    logView.alwaysBounceVertical = YES;
    [self.view addSubview:logView];
}

- (void)cleanLog_activity:(id)sender
{
    count = 0;
    accept_times_label.text = [NSString stringWithFormat:@"Times : %d",count];
    [self init_logView];
}

#pragma mark - apiToken_activity
- (void)apiToken_activity:(id)sender
{
    //
}

@end
