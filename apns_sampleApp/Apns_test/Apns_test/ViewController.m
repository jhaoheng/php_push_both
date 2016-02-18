//
//  ViewController.m
//  Apns_test
//
//  Created by jhaoheng on 2016/2/17.
//  Copyright © 2016年 max. All rights reserved.
//

#import "ViewController.h"

@interface ViewController ()
{
    UILabel *token_label;
    UILabel *logTextLabel;
}

@end

@implementation ViewController
@synthesize passToken=_passToken, passUserInfo=_passUserInfo;

- (void)setPassToken:(NSString *)passToken
{
    NSLog(@"token is : %@",passToken);
    
    _passToken = passToken;
    
    token_label.text = _passToken;
}

- (void)setPassUserInfo:(NSDictionary *)passUserInfo
{
    _passUserInfo = passUserInfo;
    logTextLabel.text = [NSString stringWithFormat:@"%@",_passUserInfo];
    
}


- (void)viewDidLoad {
    [super viewDidLoad];
    self.view.backgroundColor = [UIColor whiteColor];
    // Do any additional setup after loading the view, typically from a nib.
    
    //
    UILabel *tokenTitle = [[UILabel alloc] initWithFrame:CGRectMake(10, 100, CGRectGetWidth(self.view.frame)-20, 0)];
    tokenTitle.text = @"Device Token is : ";
    [tokenTitle sizeToFit];
    [self.view addSubview:tokenTitle];
    
    //
    token_label = [[UILabel alloc] initWithFrame:CGRectMake(10, CGRectGetMaxY(tokenTitle.frame)+10, CGRectGetWidth(self.view.frame)-20, 50)];
    token_label.numberOfLines = 0;
    token_label.lineBreakMode = NSLineBreakByCharWrapping;
    token_label.text = @"hello, wait to get token.";
    [self.view addSubview:token_label];
    
    //uibutton pass token
    UIButton *passTokenToSelf_btn = [UIButton buttonWithType:UIButtonTypeCustom];
    passTokenToSelf_btn.frame = CGRectMake((CGRectGetWidth(self.view.frame)-150)/2, CGRectGetMaxY(token_label.frame)+50, 150, 44);
    [passTokenToSelf_btn setTitle:@"Send Token" forState:UIControlStateNormal];
    [passTokenToSelf_btn setTitleColor:[UIColor blackColor] forState:UIControlStateNormal];
    [passTokenToSelf_btn addTarget:self action:@selector(pass_activity:) forControlEvents:UIControlEventTouchUpInside];
    passTokenToSelf_btn.layer.cornerRadius = 10;
    passTokenToSelf_btn.layer.borderColor = [UIColor blackColor].CGColor;
    passTokenToSelf_btn.layer.borderWidth = .5;
    [self.view addSubview:passTokenToSelf_btn];
    
    //
    logTextLabel = [[UILabel alloc] initWithFrame:CGRectMake(10, CGRectGetMaxY(passTokenToSelf_btn.frame)+10, CGRectGetWidth(self.view.frame)-20, CGRectGetHeight(self.view.frame)-CGRectGetMaxY(passTokenToSelf_btn.frame)-20)];
    
    logTextLabel.backgroundColor = [UIColor blackColor];
    
    logTextLabel.text = @"";
    logTextLabel.textColor = [UIColor whiteColor];
    logTextLabel.numberOfLines = 0;
    logTextLabel.lineBreakMode = NSLineBreakByCharWrapping;
    [self.view addSubview:logTextLabel];
    
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

@end
