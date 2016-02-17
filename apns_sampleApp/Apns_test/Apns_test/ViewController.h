//
//  ViewController.h
//  Apns_test
//
//  Created by jhaoheng on 2016/2/17.
//  Copyright © 2016年 max. All rights reserved.
//

#import <UIKit/UIKit.h>
#import <MessageUI/MFMailComposeViewController.h>

@interface ViewController : UIViewController<MFMailComposeViewControllerDelegate>

@property (nonatomic, retain) NSString *passToken;

@end

